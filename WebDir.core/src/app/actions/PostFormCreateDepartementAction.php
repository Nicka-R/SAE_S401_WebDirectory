<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;

class PostFormCreateDepartementAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //form data
        $data = $request->getParsedBody();
       
        $annuaireService = new AnnuaireService();
        
        $annuaireService->createDepartement($data);

        return $response->withHeader('Location', '/form/create/departement')->withStatus(302);

    }
}