<?php 

namespace web\directory\api\app\actions;

use web\directory\api\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetImageAction extends AbstractAction{
    public function __invoke(Request $request, Response $response, array $args): Response{
        try{
            $img = $args['img'];
            // var_dump($img);die;
            $extensions = ['png', 'jpg', 'jpeg', 'gif'];
            foreach($extensions as $ext){
                $image_path = __DIR__.'/../../../../img/'.$img . '.' . $ext;
                if(file_exists($image_path)){
                    break;
                }
            }
            if(!file_exists($image_path)){
                throw new \Exception('Image not found');
            }
            $image = file_get_contents($image_path);
            $response->getBody()->write($image);
            $mime_type = 'image/jpg'; // Valeur par défaut
            if (preg_match('/\.(\w+)$/', $image_path, $matches)) {
                switch (strtolower($matches[1])) {
                    case 'png':
                        $mime_type = 'image/png';
                        break;
                    case 'gif':
                        $mime_type = 'image/gif';
                        break;
                }
            }
            
            return $response->withHeader('Content-Type', $mime_type);
        }catch(\Exception $e){
            $response->getBody()->write(json_encode(['error'=>$e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
   
}