<?php

namespace web\directory\app\actions;

use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\core\services\annuaire\AnnuaireException;
use web\directory\app\utils\CsrfService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class GetListEntreeAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
            // view twig 
            $view = Twig::fromRequest($request);

            $annuaireService = new AnnuaireService();
            $csrf_token = CsrfService::generate('entree');

            return $view->render($response, 'view_entree.html.twig',
                                            [
                                                'message' => null,
                                                'personnes'=>$annuaireService->displayEntree(),    
                                                'departements'=>$annuaireService->getDepartements(),
                                                'services'=>$annuaireService->getServices(),
                                                'csrf_token' => $csrf_token,                              
                                            ]);
        }catch(AnnuaireException $e){
            return $view->render($response, 'view_entree.html.twig', ['message' => $e->getMessage(), 'csrf_token' => CsrfService::generate('entree')]);
        }
        catch(\Exception $e){
            return $view->render($response, 'view_entree.html.twig', ['message' => "Impossible d'afficher les entrées (get)", 'csrf_token' => CsrfService::generate('entree')]);
        }

    }
}