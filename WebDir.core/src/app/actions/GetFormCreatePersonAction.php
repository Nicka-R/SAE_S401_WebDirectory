<?php

namespace web\directory\app\actions;

use web\directory\core\services\annuaire\AnnuaireService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

/* UserDataService */
use web\directory\core\services\userData\UserDataService;


class GetFormCreatePersonAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);

        $userService = new UserDataService(); 
        $annuaireService = new AnnuaireService();        


        return $view->render($response, 'form_create_person.html.twig',
                                        [
                                        'services'=>$userService->getServices(),
                                        'departements'=>$annuaireService->getDepartements(),
                                        'fonctions'=>$userService->getFonctions()
                                        ]);
       
    }
}