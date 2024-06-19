<?php
namespace web\directory\api\app\actions;
use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\userData\UserDataService;

class EntreeById extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
            $id = $args['id'];
            $data = (new UserDataService())->getPersonne($id);
            if($data){
                $departement = (new UserDataService())->getDepartement($id);
                $dataDepartement = array_map(function($departement){
                    return [
                        'libelle' => $departement['libelle'],
                        'id' => $departement['id']
                    ];
                }, $departement);
                $service = (new UserDataService())->getPersonnesService($id);
                $dataService = array_map(function($service){
                    return [
                        'libelle' => $service['libelle'],
                        'id' => $service['id']
                    ];
                }, $service);

                $numero = (new UserDataService())->getPersonnesNumero($id);
                $dataNumero = array_map(function($numero){
                    return [
                        'libelle' => $numero['libelle'],
                        'numero' => $numero['numero'],
                    ];
                }, $numero);
                $data['departement'] = $dataDepartement;
                $data['service'] = $dataService;
                $data['numero'] = $dataNumero;

            }
            $json = json_encode($data);
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        }catch(\Exception $e){
            $response->getBody()->write(json_encode(['error'=>$e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
   
}
