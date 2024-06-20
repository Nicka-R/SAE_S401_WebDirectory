<?php

namespace web\directory\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\core\services\authorization\AuthorizationService;
use web\directory\app\utils\CsrfService;
use Slim\Views\Twig;

class GetFormCreateServiceAction extends AbstractAction
{
    private $operationCode;
    public function __construct($operationCode)
    {
        $this->operationCode = 1;
    } 
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {

        $view = Twig::fromRequest($request);
        $authorise = new AuthorizationService();
        try {
            if(AuthenticateService::isAuthenticate()){
                if($authorise->isGranted($_SESSION['USER'], $this->operationCode)){
                    // Générer un jeton CSRF
                    return $view->render($response, 'form_create_service.html.twig', [
                        'csrf_token' => CsrfService::generate('service'),
                        'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                    ]);
                }else{
                    return $view->render(
                        $response,
                        'error.html.twig',
                        [
                            'message_error' => 'Vous n\'avez pas les droits pour accéder à cette page',
                            'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                            'code_error' => 403
                        ]
                    );
                }
            }
            
            //Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
            return $response->withHeader('Location', '/account/login')->withStatus(302);
        } catch (\Exception $e) {
            // Gérer les exceptions survenues lors de la connexion
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'message_error' => $e->getMessage(),
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                    'code_error' => 500
                ]
            );
        }
    }
}