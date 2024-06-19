<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\app\utils\CsrfService;
use Slim\Views\Twig;

class GetLoginAction extends AbstractAction
{
    // Implémentation de la méthode __invoke qui sera appelée lorsqu'une instance de cette classe sera utilisée comme une fonction
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            // Initialisation de Twig à partir de la requête pour rendre les templates
            $view = Twig::fromRequest($request);
            
            // Rendre le template 'login.html.twig' avec les données nécessaires
            return $view->render($response, 'login.html.twig', [
                'csrf' => CsrfService::generate('2'),
                'userIsAuthenticate' => AuthenticateService::isAuthenticate()
            ]);

        } catch (\Exception $e) {
            // En cas d'exception, rendre un template d'erreur avec le message et le code d'erreur
            return $view->render($response, 'error.html.twig', [
                'message_error' => $e->getMessage(),
                'code_error' => 500
            ]);
        }
    }
}