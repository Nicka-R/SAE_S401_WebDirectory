<?php

namespace web\directory\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;
use Slim\Views\Twig;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\core\services\userData\UserDataService;

class PostListEntreeAction extends AbstractAction
{
    private $departementId = null;
    private $serviceId = null;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        $data = $request->getParsedBody();
        $annuaireService = new AnnuaireService();
        $userData = new UserDataService();

        if (isset($data['form_type'])) {
            if ($data['form_type'] === 'search_form') {
                // Form data for search
                $this->departementId = $data['departement'] ?? null;
                $this->serviceId = $data['service'] ?? null;

                var_dump($this->departementId);
            } elseif ($data['form_type'] === 'delete_form') {
                // Form data for delete
                if (isset($data['personne_id'])) {
                    $userData->switchStatut($data['personne_id']);
                }
                // Retain the search criteria from the hidden fields
                $this->departementId = $data['departement'] ?? null;
                $this->serviceId = $data['service'] ?? null;
            }
        }

        return $view->render($response, 'view_entree.html.twig', [
            'personnes' => $annuaireService->displayEntree($this->departementId, $this->serviceId),
            'departements' => $annuaireService->getDepartements(),
            'services' => $annuaireService->getServices(),
            'deptSet' => $this->departementId,
            'servSet' => $this->serviceId,
            'userIsAuthenticate' => AuthenticateService::isAuthenticate()
        ]);
    }
}
