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
            $json = json_encode($data);
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        }catch(\Exception $e){
            $response->getBody()->write(json_encode(['error'=>$e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
   
}
