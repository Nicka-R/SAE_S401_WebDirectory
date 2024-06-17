<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;
use Slim\Views\Twig;


class PostListEntreeAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {

        $view = Twig::fromRequest($request);

        //form data
        $data = $request->getParsedBody();

        $departementId = $data['departement'] ?? null;
        $serviceId = $data['service'] ?? null;
        $annuaireService = new AnnuaireService();

        return $view->render($response, 'view_entree.html.twig', [
            'personnes' => $annuaireService->displayEntree( $departementId,$serviceId),
            'departements' => $annuaireService->getDepartements(),
            'services' => $annuaireService->getServices(),
        ]);

    }
}