<?php

namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\annuaire\AnnuaireService;

class GetDepartements extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        $data = (new AnnuaireService())->getDepartements();

        $json = json_encode($data);
        $response->getBody()->write($json);
        return $response->withHeader('Content-Type', 'application/json');
       
    }
}