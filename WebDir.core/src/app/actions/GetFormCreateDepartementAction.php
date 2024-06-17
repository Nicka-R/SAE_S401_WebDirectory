<?php

namespace web\directory\app\actions;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class GetFormCreateDepartementAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);       

        return $view->render($response, 'form_create_departement.html.twig');
       
    }
}