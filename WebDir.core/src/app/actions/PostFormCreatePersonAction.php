<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PostFormCreatePersonAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //form data
        $data = $request->getParsedBody();
        
        return $response->withHeader('Location', '/form/create/person')->withStatus(302);

    }
}