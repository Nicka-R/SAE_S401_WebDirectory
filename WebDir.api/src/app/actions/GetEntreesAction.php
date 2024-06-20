<?php

namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\api\core\services\userData\UserDataService;
use web\directory\api\core\services\exceptions\UserDataException;

class GetEntreesAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
            $personne = (new UserDataService())->getEntrees();


            //si on a des paramètres de tri dans l'url
            $sort = $request->getQueryParams()['sort'] ?? null;
            if($sort){
                $personne = (new UserDataService())->getEntrees($sort);
            }
            
            // récupérer le nom et prénom des personnes
            $data= array_map(function($personne){
                if($personne['statut'] != 1) {
                    return; 
                }
                $departement = (new UserDataService())->getDepartement($personne['id']);
                $dataDepartement = array_map(function($departement){
                    return [
                        'libelle' => $departement['libelle'],
                        'id' => $departement['id']
                    ];
                }, $departement);

                $service = (new UserDataService())->getPersonnesService($personne['id']);
                $dataService = array_map(function($service){
                    return [
                        'libelle' => $service['libelle'],
                        'id' => $service['id']
                    ];
                }, $service);
                if (!empty($personne['img'])) {
                    // Extraire le nom de fichier sans l'extension
                    $imgFileName = pathinfo($personne['img'], PATHINFO_FILENAME);
                    // Mettre à jour $personne['img'] avec le nom de fichier sans extension
                    $personne['img'] = $imgFileName;
                }
                return [
                    'nom' => $personne['nom'],
                    'prenom' => $personne['prenom'],
                    'departement' => $dataDepartement,
                    'service' => $dataService,
                    'img' => $personne['img'],
                    'links' => [
                        'self' => [ 
                            'href' => '/api/entrees/'.$personne['id']
                        ]
                        ],
                    'statut' => $personne['statut']
                ];

            }, $personne);
            $data = array_filter($data, function($value) { return !is_null($value); });
            $json = json_encode($data);
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        }catch(UserDataException $e){
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}