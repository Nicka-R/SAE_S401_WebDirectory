<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\core\services\annuaire\AnnuaireException;
use web\directory\app\utils\CsrfService;
use Slim\Views\Twig;

class PostFormCreateServiceAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $twig = Twig::fromRequest($request);
        try{
            // check csrf token
            $data = $request->getParsedBody();
            if (!isset($data['csrf_token']) || !CsrfService::check('service', $data['csrf_token'])) {
                throw new \Exception('Les données du formulaires ont étés détéctées comme suspectes, il s\'agit peut-être d\'un rechargement de la page, veuillez réessayer.');
            }
        
            $annuaireService = new AnnuaireService();
            $filteredData = filter_var_array($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $annuaireService->createService($filteredData);

            return $twig->render($response, 'form_create_service.html.twig', ['message' => 'Service créé avec succès', 'csrf_token' => CsrfService::generate('service')]);
        }catch(AnnuaireExceptions $e){
            return $twig->render($response, 'form_create_service.html.twig', ['message' => $e->getMessage(), 'csrf_token' => CsrfService::generate('service')]);
        }
        catch(\Exception $e){
            return $twig->render($response, 'form_create_service.html.twig', ['message' => $e->getMessage(), 'csrf_token' => CsrfService::generate('service')]);
        }

    }
}