<?php

namespace web\directory\app\actions;


use web\directory\app\actions\AbstractAction;

use web\directory\app\utils\CsrfService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification as authentification;
use Slim\Views\Twig;


class PostLoginAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            // Récupérer l'instance de Twig depuis la requête
            $view = Twig::fromRequest($request);

            // Récupérer les données du formulaire
            $data = $request->getParsedBody();

            //verifier le crsf token
            if (!isset($data['csrf']) || !CsrfService::check('login', $data['csrf'])) {
                throw new \Exception('Les données du formulaires ont étés détéctées comme suspectes, il s\'agit peut-être d\'un rechargement de la page, veuillez réessayer.');
            }

            // Créer une instance du service d'authentification
            $authService = new authentification\AuthenticateService();

            // Préparer les valeurs pour la connexion
            $values = [
                'email' => $data['email'] ?? null,
                'password' => $data['password'] ?? null,
                'csrf' => $data['csrf'] ?? null,
                'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate() 
            ];

            // Tenter de connecter l'utilisateur
            $authService->login($values);

            // Rediriger vers la page d'accueil après la connexion réussie
            return $response->withHeader('Location', '/')->withStatus(302);
        } catch (\Exception $e) {
            // Gérer les exceptions survenues lors de la connexion
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'message_error' => $e->getMessage(),
                    'code_error' => $e->getCode()
                ]
            );
        }
    }
}