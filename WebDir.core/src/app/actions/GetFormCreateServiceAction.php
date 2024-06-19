<?php

namespace web\directory\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\app\utils\CsrfService;
use Slim\Views\Twig;

class GetFormCreateServiceAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {


        $view = Twig::fromRequest($request);
        try {
            return $view->render($response, 'form_create_service.html.twig', [
                'csrf_token' => CsrfService::generate('service'),
                'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
            ]);
        } catch (\Exception $e) {
            // Gérer les exceptions survenues lors de la connexion
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'message_error' => $e->getMessage(),
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                    'code_error' => 500
                ]
            );
        }
    }
}