<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\core\services\annuaire\AnnuaireException;
use web\directory\app\utils\CsrfService;
use Slim\Views\Twig;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\core\services\userData\UserDataService;
use web\directory\core\services\userData\UserDataException;


class PostListEntreeAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);
        $annuaireService = new AnnuaireService();
        $userData = new UserDataService();
        //form data
        $data = $request->getParsedBody();
        $filteredData = filter_var_array($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $departementId = $filteredData['departement'] ?? null;
        $serviceId = $filteredData['service'] ?? null;

        try{

            if (!isset($data['csrf_token']) || !CsrfService::check('entree', $data['csrf_token'])) {
                throw new \Exception('Les données du formulaires ont étés détéctées comme suspectes, il s\'agit peut-être d\'un rechargement de la page, veuillez réessayer.');
            }
            
            if(isset($data['personne_id'])){
                $userData->switchStatut($data['personne_id']);
            }

            return $view->render($response, 'view_entree.html.twig', [
                'message' => null,
                'personnes' => $annuaireService->displayEntree( $departementId,$serviceId),
                'departements' => $annuaireService->getDepartements(),
                'services' => $annuaireService->getServices(),
                'csrf_token' => CsrfService::generate('entree'),
                'userIsAuthenticate' => AuthenticateService::isAuthenticate()
            ]);

        }catch(UserDataException $e){
            return $view->render($response, 'view_entree.html.twig', ['message' => $e->getMessage(),'personnes' => $annuaireService->displayEntree( $departementId,$serviceId),
                'departements' => $annuaireService->getDepartements(),
                'services' => $annuaireService->getServices(), 'csrf_token' => CsrfService::generate('entree'), 'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);
        }catch(AnnuaireException $e){
            return $view->render($response, 'view_entree.html.twig', ['message' => $e->getMessage(), 'personnes' => $annuaireService->displayEntree( $departementId,$serviceId),
                'departements' => $annuaireService->getDepartements(),
                'services' => $annuaireService->getServices(), 'csrf_token' => CsrfService::generate('entree'), 'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);
        }catch(\Exception $e){
            return $view->render($response, 'view_entree.html.twig', ['message' => $e->getMessage(), 'personnes' => $annuaireService->displayEntree( $departementId,$serviceId),
                'departements' => $annuaireService->getDepartements(),
                'services' => $annuaireService->getServices(), 'csrf_token' => CsrfService::generate('entree'), 'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);
        }
        
        return $view->render($response, 'view_entree.html.twig', [
            'personnes' => $annuaireService->displayEntree( $departementId,$serviceId),
            'departements' => $annuaireService->getDepartements(),
            'services' => $annuaireService->getServices(),
            'userIsAuthenticate' => AuthenticateService::isAuthenticate() // Vérifier si l'utilisateur est authentifié

            
        ]);

    }
}