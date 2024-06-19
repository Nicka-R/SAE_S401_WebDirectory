<?php

namespace web\directory\app\actions;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class GetFormCreateServiceAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);       

        return $view->render($response, 'form_create_service.html.twig',[
            'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
        ]);
       
    }
}