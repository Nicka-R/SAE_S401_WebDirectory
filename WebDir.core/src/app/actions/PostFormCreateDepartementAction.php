<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\core\services\annuaire\AnnuaireException;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class PostFormCreateDepartementAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        
        $twig = Twig::fromRequest($request);
        try{
            // check csrf token
            $data = $request->getParsedBody();
            if (!isset($data['csrf_token']) || !CsrfService::check('departement', $data['csrf_token'])) {
                throw new \Exception('Les données du formulaires ont étés détéctées comme suspectes, il s\'agit peut-être d\'un rechargement de la page, veuillez réessayer.');
            }
            $filteredData = filter_var_array($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $annuaireService = new AnnuaireService();
            
            $annuaireService->createDepartement($filteredData);

            return $twig->render($response, 'form_create_departement.html.twig', ['message' => 'Département créé avec succès', 'csrf_token' => CsrfService::generate('departement'),'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);

        }catch(AnnuaireException $e){
            return $twig->render($response, 'form_create_departement.html.twig', ['message' => $e->getMessage(), 'csrf_token' => CsrfService::generate('departement'),'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);
        }
        catch(\Exception $e){
            $csrf_token = CsrfService::generate('departement');
            return $twig->render($response, 'form_create_departement.html.twig', ['message' => $e->getMessage(), 'csrf_token' => CsrfService::generate('departement'),'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);
        }
        
    }
}