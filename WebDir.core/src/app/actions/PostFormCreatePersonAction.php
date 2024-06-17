<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\userDataManagementService\UserDataManagementService;

class PostFormCreatePersonAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        //form data
        $data = $request->getParsedBody();
        $userDataManager = new UserDataManagementService();

        $userDataManager->addPerson($data);


        return $response->withHeader('Location', '/form/create/person')->withStatus(302);

    }
}