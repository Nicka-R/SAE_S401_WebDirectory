<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\annuaire\AnnuaireException;
use web\directory\core\services\authentification as authentification;

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

        
            $annuaireService = new AnnuaireService();
            $filteredData = filter_var_array($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $annuaireService->createService($filteredData);

            return $twig->render($response, 'form_create_service.html.twig', ['message' => 'Service créé avec succès', 'csrf_token' => CsrfService::generate('service'), 
            'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(),
        ]);
        }catch(AnnuaireException $e){
           
            return $twig->render(
                $response,
                'form_create_service.html.twig',
                [
                    'error_message' => $e->getMessage(),
                    'code_error' => 400,
                    'csrf' => CsrfService::generate('1'), // Générer un jeton CSRF
                    'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                ]
            );
        }catch(\Exception $e){
            return $twig->render(
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