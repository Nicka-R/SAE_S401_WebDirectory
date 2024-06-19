<?php

namespace web\directory\app\actions;

use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\core\services\annuaire\AnnuaireException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification\AuthenticateService;
use web\directory\core\services\authorization\AuthorizationService;
use Slim\Views\Twig;

class GetListEntreeAction extends AbstractAction{
    
    private $operationCode;
    public function __construct($operationCode)
    {
        $this->operationCode = 1;
    } 

    public function __invoke(Request $request, Response $response, array $args): Response{
        // view twig 
        $view = Twig::fromRequest($request);
        try{
            $annuaireService = new AnnuaireService();
            $authorise = new AuthorizationService();

            if(AuthenticateService::isAuthenticate()){
                //on vérifie que la personne connectée a les droits pour créer un département
                if($authorise->isGranted($_SESSION['USER'], $this->operationCode)){
                    return $view->render($response, 'view_entree.html.twig',
                                                [
                                                    'message' => null,
                                                    'personnes'=>$annuaireService->displayEntree(),    
                                                    'departements'=>$annuaireService->getDepartements(),
                                                    'services'=>$annuaireService->getServices(),
                                                    'deptSet' => '',
                                                    'servSet' => '',
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
        }catch(AnnuaireException $e){
            return $view->render($response, 'view_entree.html.twig', ['message' => $e->getMessage(),  'userIsAuthenticate' => AuthenticateService::isAuthenticate()]);
        }
        catch (\Exception $e) {
            // Gérer les exceptions survenues lors de la connexion
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate(),
                    'message_error' => $e->getMessage(),
                    'code_error' => 500
                ]
            );
        }

    }
}