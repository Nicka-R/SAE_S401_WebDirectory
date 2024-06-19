<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class GetDefaultAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {

        // view twig 
        $view = Twig::fromRequest($request);
        try {
            return $view->render(
                $response,
                'base.html.twig',
                ['userIsAuthenticate' => AuthenticateService::isAuthenticate()]
            );
        } catch (\Exception $e) {
            // Gérer les exceptions survenues lors de la connexion
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'message_error' => $e->getMessage(),
                    'code_error' => 500
                ]
            );
        }
    }
}