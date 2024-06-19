<?php

namespace web\directory\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;
use Slim\Views\Twig;
use web\directory\core\services\authentification as authentification;
use web\directory\core\services\userData\UserDataService;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\annuaire\AnnuaireException;

class PostListEntreeAction extends AbstractAction
{
    private $departementId = null;
    private $serviceId = null;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);

        try {
            $data = $request->getParsedBody();
            $annuaireService = new AnnuaireService();
            $userData = new UserDataService();

            if (isset($data['form_type'])) {
                if ($data['form_type'] === 'search_form') {
                    // Form data for search
                    $this->departementId = $data['departement'] ?? null;
                    $this->serviceId = $data['service'] ?? null;

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
                'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate()
            ]);
        }catch(AnnuaireException $e){
           
            return $view->render(
                $response,
                'view_entree.html.twig',
                [
                    'error_message' => $e->getMessage(),
                    'code_error' => 400,
                    'csrf_token' => CsrfService::generate('1'), // Générer un jeton CSRF
                    'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                ]
            );
        }catch(\Exception $e){
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'message_error' => $e->getMessage(),
                    'code_error' => 500,
                    'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                ]
            );
        }
    }
}