<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use web\directory\core\services\AdministratorManagerService;




class GetDefaultAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);

        $personne_test = new AdministratorManagerService();

        return $view->render($response, 'base.html.twig',['personnes'=>$personne_test->getPersonne()]);
       
    }
}