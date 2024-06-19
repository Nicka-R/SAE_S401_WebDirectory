<?php

namespace web\directory\core\services\authentification;

use web\directory\app\utils\CsrfService;
use web\directory\core\domain\entities\Administrator;
use Exception;

class AuthenticateService implements AuthenticateInterface
{

    protected string $email;       // Propriété pour stocker l'email de l'utilisateur connecté
    protected int $role;           // Propriété pour le rôle de l'utilisateur

    /**
     * Méthode de connexion de l'utilisateur.
     *
     * @param array $values Tableau des valeurs de connexion (email, password, csrf).
     * @throws Exception En cas d'erreur lors de la connexion.
     */
    public function login($values)
    {
        try {
            // Vérifie le jeton CSRF pour prévenir les attaques CSRF
            CsrfService::check('2',$values['csrf']);

            // Récupère l'email et le mot de passe du tableau $values
            $email = $values['email'] ?? null;
            $password = $values['password'] ?? null;

            // Vérifie si l'email ou le mot de passe ne sont pas renseignés
            if (!$email || !$password) {
                throw new AuthServiceNoDataException('Email or password not provided');
            }

            // Récupère l'utilisateur depuis la base de données
            $user = Administrator::where('mail', '=', $email)->first();

            // Vérifie si l'utilisateur existe
            if (!$user) {
                throw new AuthServiceNotFoundException("User does not exist");
            }

            // Vérifie si le mot de passe correspond
            if (!password_verify($password, $user->mdp)) {
                throw new AuthServiceBadDataException('Incorrect email or password');
            }

            // Stocke l'email de l'utilisateur dans la session
            $this->email = $user->mail;
            $this->role = $user->role;
            $_SESSION['USER'] = $this->email;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Méthode d'inscription d'un nouvel utilisateur.
     *
     * @param array $values Tableau des valeurs d'inscription (email, password1, password2, csrf).
     * @throws Exception En cas d'erreur lors de l'inscription.
     */
    public function register(array $values)
    {
        try {
            // Vérifie le jeton CSRF pour prévenir les attaques CSRF
            CsrfService::check('1',$values['csrf']);

            // Récupère l'email, le mot de passe 1 et le mot de passe 2 du tableau $values
            $email = $values['email'] ?? null;
            $password1 = $values['password1'] ?? null;
            $password2 = $values['password2'] ?? null;

            // Vérifie si l'email ou les mots de passe ne sont pas renseignés
            if (!$email || !$password1 || !$password2) {
                throw new AuthServiceNoDataException('Email or password not provided');
            }

            // Vérifie si les mots de passe saisis correspondent
            if ($password1 !== $password2) {
                throw new AuthServiceBadDataException('Passwords do not match');
            }

            // Vérifie si l'utilisateur existe déjà
            if ($this->userAlreadyExist($email)) {
                throw new AuthServiceBadDataException('User already exists');
            }

            // Hache le mot de passe avec password_hash
            $hashedPassword = password_hash($password1, PASSWORD_DEFAULT, ['cost' => 12]);
            $email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Vérifie si l'email est valide
            if ($email_sanitized !== $email) {
                throw new AuthServiceBadDataException('Invalid email');
            }

            // Crée un nouvel utilisateur dans la base de données
            $newUser = new Administrator();
            $newUser->mail = $email_sanitized;
            $newUser->mdp = $hashedPassword;
            $newUser->role = 1;
            $newUser->save();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Vérifie si un utilisateur existe déjà dans la base de données.
     *
     * @param string $email Email de l'utilisateur à vérifier.
     * @return bool True si l'utilisateur existe, False sinon.
     */
    public function userAlreadyExist(string $email): bool
    {
        // Recherche un utilisateur avec l'email spécifié
        $user = Administrator::where('mail', '=', $email)->exists();
        return $user;
    }

    /**
     * Déconnecte l'utilisateur en réinitialisant $_SESSION['USER'].
     */
    public function logout()
    {
        $_SESSION['USER'] = null;
    }

    /**
     * Vérifie si un utilisateur est authentifié en vérifiant si $_SESSION['USER'] est défini.
     *
     * @return bool True si l'utilisateur est authentifié, False sinon.
     */
    public static function isAuthenticate(): bool
    {
        return isset($_SESSION['USER']);
    }
}