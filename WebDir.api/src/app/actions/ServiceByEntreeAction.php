<?php
namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\annuaire\AnnuaireService;
use web\directory\api\core\services\annuaire\AnnuaireException;

class ServiceByEntreeAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
            $id = $args['id'];
            if(!$id){
                throw new AnnuaireException('id manquant');
            }
            $data = (new AnnuaireService())->getServicesByPersonne($id);
            $data = array_map(function($service){
                return [
                    'id' => $service['id'],
                    'libelle' => $service['libelle'],
                    'description' => $service['description'],
                ];
            }, $data);
            $json = json_encode($data);
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        }catch(AnnuaireException $e){
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
        
    }
}