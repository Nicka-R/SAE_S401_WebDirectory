<?php

namespace web\directory\app\actions;


use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;


class PostRegisterAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
       
            // Récupérer l'instance de Twig depuis la requête
            $view = Twig::fromRequest($request);

            // Récupérer les données du formulaire
            $data = $request->getParsedBody();

            // Créer une instance du service d'authentification
            $authService = new AuthenticateService();

            // Préparer les valeurs pour l'inscription
            $values = [
                'email' => $data['email'] ?? null,
                'password1' => $data['password1'] ?? null,
                'password2' => $data['password2'] ?? null,
                'csrf' => $data['csrf'] ?? null // Utiliser le token CSRF de la requête
            ];

            // Appeler la méthode pour enregistrer l'utilisateur
            $authService->register($values);

            // Rediriger vers la page d'accueil après l'inscription réussie
            return $response->withHeader('Location', '/')->withStatus(302);

        
    }
}