<?php

namespace web\directory\app\actions;

use web\directory\core\services\annuaire\AnnuaireService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

/* UserDataService */
use web\directory\core\services\userData\UserDataService;


class GetFormCreatePersonAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {

        // view twig 
        $view = Twig::fromRequest($request);
        try {
            $userService = new UserDataService();
            $annuaireService = new AnnuaireService();
            $csrf_token = CsrfService::generate('person');


            return $view->render(
                $response,
                'form_create_person.html.twig',
                [
                    'services' => $userService->getServices(),
                    'departements' => $annuaireService->getDepartements(),
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                    'csrf_token' => $csrf_token,
                    'message' => null
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