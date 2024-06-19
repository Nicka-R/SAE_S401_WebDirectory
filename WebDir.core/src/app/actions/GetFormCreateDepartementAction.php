<?php

namespace web\directory\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class GetFormCreateDepartementAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {

        // view twig 
        $view = Twig::fromRequest($request);
        try {
            $crsf_token = CsrfService::generate('departement');
            return $view->render(
                $response,
                'form_create_departement.html.twig',
                [
                    'csrf_token' => $crsf_token,
                    'message' => null,
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate()
                ]
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