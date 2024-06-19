<?php

namespace web\directory\app\actions;

use web\directory\core\services\annuaire\AnnuaireService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class GetListEntreeAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);
        try{
        $annuaireService = new AnnuaireService();

        return $view->render($response, 'view_entree.html.twig',
                                        [
                                        'personnes'=>$annuaireService->displayEntree(),    
                                        'departements'=>$annuaireService->getDepartements(),
                                        'services'=>$annuaireService->getServices(),
                                        'deptSet' => '',
                                        'servSet' => '',
                                        'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                                        ]);
        }catch (\Exception $e) {
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