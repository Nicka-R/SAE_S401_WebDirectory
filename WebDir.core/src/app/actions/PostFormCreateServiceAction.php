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

        //form data
        $data = $request->getParsedBody();
       
        $annuaireService = new AnnuaireService();
        
        $annuaireService->createService($data);

        return $response->withHeader('Location', '/form/create/service')->withStatus(302);

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