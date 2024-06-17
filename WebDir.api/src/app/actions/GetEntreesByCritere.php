<?php
namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\userData\UserDataService;
use web\directory\api\core\services\userData\UserDataException;

class GetEntreesByCritere extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
            $queryParams = $request->getQueryParams();
            if(empty($queryParams)) {
                $response->getBody()->write(json_encode(['error' => 'Au moins un critère de recherche est requis']));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }

            $critere = key($queryParams);
            $valeur = reset($queryParams);
            $personne = (new UserDataService())->getEntreesByCritere($critere, $valeur);
            if(empty($personne)) {
                $response->getBody()->write(json_encode(['error' => 'Aucun résultat trouvé']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            $data = array_map(function($personne){
                $personneData = [
                    'id' => $personne['id'],
                    'nom' => $personne['nom'],
                    'prenom' => $personne['prenom'],
                    'mail' => $personne['mail'],
                    'departement' => [],
                    'links' => [
                        'self' => [ 
                            'href' => '/api/entrees/'.$personne['id']
                        ]
                    ]
                ];
                    $departement = (new UserDataService())->getDepartement($personne['id']);
                    if(empty($departement)) {
                        return $personneData;
                    }else{
                        $dataDepartement = array_map(function($departement) {
                            return [
                                'libelle' => $departement['libelle'],
                                'id' => $departement['id']
                            ];
                        }, $departement);
    
                        $personneData['departement'] = $dataDepartement;
                    return $personneData;
                    }
            }, $personne);


            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (UserDataException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}