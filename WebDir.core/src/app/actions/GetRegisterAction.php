<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class GetRegisterAction extends AbstractAction
{
    // Implémentation de la méthode __invoke qui sera appelée lorsqu'une instance de cette classe sera utilisée comme une fonction
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            // Initialisation de Twig à partir de la requête pour rendre les templates
            $view = Twig::fromRequest($request);

            // Récupération du message d'erreur depuis la session, s'il y en a
            $error_message = $_SESSION['error_message'] ?? null;
            unset($_SESSION['error_message']); // Supprimer le message d'erreur de la session

            // Rendre le template 'register.html.twig' avec les données nécessaires
            return $view->render($response, 'register.html.twig', [
                'error_message' => $error_message, // Message d'erreur, s'il y a lieu
                'userIsAuthenticate' => AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                'csrf' => CsrfService::generate('1') // Générer un jeton CSRF
            ]);

        } catch (\Exception $e) {
            // En cas d'exception, rendre un template d'erreur avec le message et le code d'erreur
            return $view->render($response, 'error.html.twig', [
                'message_error' => $e->getMessage(),
                'code_error' => $e->getCode()
            ]);
        }
    }
}