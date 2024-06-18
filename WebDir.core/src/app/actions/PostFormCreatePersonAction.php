<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\userDataManagementService\UserDataManagementService;
use web\directory\core\services\userData\UserDataService;
use  web\directory\core\services\userDataManagementService\UserDataManagementException;
use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\app\utils\CsrfService;
use Slim\Views\Twig;

class PostFormCreatePersonAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        
        $twig = Twig::fromRequest($request);
        $userService = new UserDataService(); 
        $userDataManager = new UserDataManagementService();
        $annuaireService = new AnnuaireService(); 
        try{
            // check csrf token
            $data = $request->getParsedBody();
            if (!isset($data['csrf_token']) || !CsrfService::check('person', $data['csrf_token'])) {
                throw new \Exception('CSRF token invalide');
            }

            //form data
            $data = $request->getParsedBody();
            // var_dump($data);die;
            
            $userDataManager->addPerson($data);


            return $twig->render($response, 'form_create_person.html.twig', ['message' => "Utilisateur crée avec succès", 'csrf_token' => CsrfService::generate('person'), 'services'=>$userService->getServices(),
                                        'departements'=>$annuaireService->getDepartements(),
                                        'fonctions'=>$userService->getFonctions(), ]);
        }catch(UserDataManagementException $e){
            return $twig->render($response, 'form_create_person.html.twig', ['message' => $e->getMessage(), 'csrf_token' => CsrfService::generate('person'), 'services'=>$userService->getServices(),
                                        'departements'=>$annuaireService->getDepartements(),
                                        'fonctions'=>$userService->getFonctions(), ]);
        }catch(\Exception $e){
            return $twig->render($response, 'form_create_person.html.twig', ['message' => "Problème avec le serveur", 'csrf_token' => CsrfService::generate('person'), 'services'=>$userService->getServices(),
                                        'departements'=>$annuaireService->getDepartements(),
                                        'fonctions'=>$userService->getFonctions(), ]);
        }

    }
}