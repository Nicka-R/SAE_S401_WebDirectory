<?php

namespace web\directory\api\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



class GetDefaultAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        $data = [
            'title' => 'Web Directory',
            'description' => 'Annuaire de l\'université',
        ];
       $json = json_encode($data);
         $response->getBody()->write($json);
         return $response->withHeader('Content-Type', 'application/json');
    }
}