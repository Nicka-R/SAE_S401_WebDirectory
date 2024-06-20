<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\core\services\authorization\AuthorizationService;
use Slim\Views\Twig;

class GetRegisterAction extends AbstractAction
{
    private $operationCode;
    public function __construct($operationCode)
    {
        $this->operationCode = 2;
    }   
    // Implémentation de la méthode __invoke qui sera appelée lorsqu'une instance de cette classe sera utilisée comme une fonction
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {

            // Initialisation de Twig à partir de la requête pour rendre les templates
            $view = Twig::fromRequest($request);
            $authorise = new AuthorizationService();

            if(AuthenticateService::isAuthenticate()){
                //on vérifie que la personne connectée est un super admin
                if($authorise->isGranted($_SESSION['USER'], $this->operationCode)){
                    // Rendre le template 'register.html.twig' avec les données nécessaires
                    return $view->render($response, 'register.html.twig', [
                        'userIsAuthenticate' => AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                        'csrf' => CsrfService::generate('register') // Générer un jeton CSRF
                    ]); 
                }else{
                    return $view->render($response, 'error.html.twig', [
                        'message_error' => 'Vous n\'avez pas les droits pour accéder à cette page',
                        'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                        'code_error' => 403
                    ]);
                }

            }else{
                //Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
                return $response->withHeader('Location', '/account/login')->withStatus(302);
            }

            

        } catch (\Exception $e) {
            // En cas d'exception, rendre un template d'erreur avec le message et le code d'erreur
            return $view->render($response, 'error.html.twig', [
                'message_error' => $e->getMessage(),
                'userIsAuthenticate' => AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                'code_error' => 500
            ]);
        }
    }
}