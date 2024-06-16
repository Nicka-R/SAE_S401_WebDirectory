<?php

namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetDefaultAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        $data = [
            'title' => 'Web Directory',
            'links' => [
                'home' => '/',
                'services' => '/api/services',
                'entrees' => '/api/entrees',
                'entrees par service' => '/api/services/{id}/entrees',
                'entree complete' => '/api/entrees/{id}',
                'entrees répondant à un critère' => '/api/entrees?critere=valeur'

            ]
        ];
       $json = json_encode($data);
         $response->getBody()->write($json);
         return $response->withHeader('Content-Type', 'application/json');
    }
}