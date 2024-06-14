<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

/* userDataHarvestService */
use web\directory\core\services\userDataHarvestService\UserDataHarvestService;


class GetFormCreatePerson extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);

        $userData = new userDataHarvestService();        

        return $view->render($response, 'form_create_person.html.twig',
                                        [
                                        'services'=>$userData->getServices(),
                                        'departements'=>$userData->getDepartements()
                                        ]);
       
    }
}