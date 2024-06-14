<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;




class GetDefaultAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{

        // view twig 
        $view = Twig::fromRequest($request);

        return $view->render($response, 'welcome_page.html.twig');
       
    }
}