<?php


namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\userDataHarvestService\UserDataHarvestService;
use web\directory\api\core\services\exceptions\UserDataException;

class GetEntreesAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
        $personne = (new UserDataHarvestService())->getEntrees();

        // récupérer le nom et prénom des personnes
        $data= array_map(function($personne){
            $departement = (new UserDataHarvestService())->getDepartement($personne['id']);
            $dataDepartement = array_map(function($departement){
                return [
                    'libelle' => $departement['libelle'],
                    'id' => $departement['id']
                ];
            }, $departement);

            return [
                'nom' => $personne['nom'],
                'prenom' => $personne['prenom'],
                'departement' => $dataDepartement,
                'links' => [
                    'self' => [ 
                        'href' => '/api/entrees/'.$personne['id']
                    ]
                ]
            ];
        }, $personne);
        $json = json_encode($data);
        $response->getBody()->write($json);
        return $response->withHeader('Content-Type', 'application/json');
        }catch(UserDataException $e){
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}