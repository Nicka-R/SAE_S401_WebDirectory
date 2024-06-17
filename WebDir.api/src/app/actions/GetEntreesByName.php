<?php
namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\userData\UserDataService;
use web\directory\api\core\services\userData\UserDataException;

class GetEntreesByName extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
        if(!isset($request->getQueryParams()['nom'])){
            $response->getBody()->write(json_encode(['error' => 'Le parametre nom est obligatoire']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        $nom = $request->getQueryParams()['nom'] ?? null;
        $personne = (new UserDataService())->getEntreesByNom($nom);
        $data = array_map(function($personne){
            $departement = (new UserDataService())->getDepartement($personne['id']);
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