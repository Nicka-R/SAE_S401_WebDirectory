<?php

namespace web\directory\core\services\authentification;

use web\directory\app\utils\CsrfService;
use web\directory\core\domain\entities\Administrator;
use Exception;

class AuthenticateService implements AuthenticateInterface
{      

    /**
     * Méthode de connexion de l'utilisateur.
     *
     * @param array $values Tableau des valeurs de connexion (email, password, csrf).
     * @throws Exception En cas d'erreur lors de la connexion.
     */
    public function login($values)
    {
        try {

            // Récupère l'email et le mot de passe du tableau $values
            $email = $values['email'] ?? null;
            $password = $values['password'] ?? null;

            // Vérifie si l'email ou le mot de passe ne sont pas renseignés
            if (!$email || !$password) {
                throw new AuthServiceNoDataException('Veuillez renseigner votre email et votre mot de passe');
            }

            // Récupère l'utilisateur depuis la base de données
            $user = Administrator::where('mail', '=', $email)->first();

            // Vérifie si l'utilisateur existe
            if (!$user) {
                throw new AuthServiceNotFoundException("L'utilisateur n'existe pas, demandez à l'administrateur de vous créer un compte.");
            }

            // Vérifie si le mot de passe correspond
            if (!password_verify($password, $user->mdp)) {
                throw new AuthServiceBadDataException('Mot de passe incorrect');
            }

            // Stocke l'id de l'utilisateur dans la session
            $_SESSION['USER'] = $user->id;

        } catch (AuthServiceNoDataException $e) {
            throw new AuthServiceNoDataException($e->getMessage());
        }catch (AuthServiceBadDataException $e) {
            throw new AuthServiceBadDataException($e->getMessage());
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

            // Récupère l'email, le mot de passe 1 et le mot de passe 2 du tableau $values
            $email = $values['email'] ?? null;
            $password1 = $values['password1'] ?? null;
            $password2 = $values['password2'] ?? null;

            // Vérifie si l'email ou les mots de passe ne sont pas renseignés
            if (!$email || !$password1 || !$password2) {
                throw new AuthServiceNoDataException('Veuillez renseigner votre email et vos mots de passe');
            }

            // Vérifie si les mots de passe saisis correspondent
            if ($password1 !== $password2) {
                throw new AuthServiceBadDataException('Les mots de passe ne correspondent pas');
            }

            // Vérifie si l'utilisateur existe déjà
            if ($this->userAlreadyExist($email)) {
                throw new AuthServiceBadDataException('L\'utilisateur existe déjà');
            }

            // Hache le mot de passe avec password_hash
            $hashedPassword = password_hash($password1, PASSWORD_DEFAULT, ['cost' => 12]);
            $email_sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Vérifie si l'email est valide
            if ($email_sanitized !== $email) {
                throw new AuthServiceBadDataException('Email invalide');
            }

            // Crée un nouvel utilisateur dans la base de données
            $newUser = new Administrator();
            $newUser->mail = $email_sanitized;
            $newUser->mdp = $hashedPassword;
            $newUser->role = 1;
            $newUser->save();

        } catch (AuthServiceNoDataException $e) {
            throw new AuthServiceNoDataException($e->getMessage());
        }catch (AuthServiceBadDataException $e) {
            throw new AuthServiceBadDataException($e->getMessage());
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
        session_destroy();
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