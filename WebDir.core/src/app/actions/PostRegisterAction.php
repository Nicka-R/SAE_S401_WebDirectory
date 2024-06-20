<?php

namespace web\directory\app\actions;


use web\directory\app\actions\AbstractAction;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\authentification\AuthServiceBadDataException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\authentification as authentification;
use Slim\Views\Twig;


class PostRegisterAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {

        try{
            // Récupérer l'instance de Twig depuis la requête
            $view = Twig::fromRequest($request);

            // Récupérer les données du formulaire
            $data = $request->getParsedBody();

            // Vérifier le token CSRF
            if (!isset($data['csrf']) || !CsrfService::check('register', $data['csrf'])) {
                throw new \Exception('Les données du formulaires ont étés détéctées comme suspectes, il s\'agit peut-être d\'un rechargement de la page, veuillez réessayer.');
            }

            // Créer une instance du service d'authentification
            $authService = new authentification\AuthenticateService();

            // Préparer les valeurs pour l'inscription
            $values = [
                'email' => $data['email'] ?? null,
                'password1' => $data['password1'] ?? null,
                'password2' => $data['password2'] ?? null,
            ];

            // Appeler la méthode pour enregistrer l'utilisateur
            $authService->register($values);

            // Rediriger vers la page d'accueil après l'inscription réussie
            return $view->render($response, 'register.html.twig', [
                'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                'csrf' => CsrfService::generate('register')
            ]);
        }catch(authentification\AuthServiceNoDataException $e){
          
            return $view->render(
                
                $response,
                'register.html.twig',
                [
                    'error_message' => $e->getMessage(),
                    'code_error' => 400,
                    'csrf' => CsrfService::generate('1'),
                    'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                ]
            );
        }catch(AuthServiceBadDataException $e){
           
            return $view->render(
                $response,
                'register.html.twig',
                [
                    'error_message' => $e->getMessage(),
                    'code_error' => 400,
                    'csrf' => CsrfService::generate('1'), // Générer un jeton CSRF
                    'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                ]
            );
        }catch(\Exception $e){
            return $view->render(
                $response,
                'error.html.twig',
                [
                    'message_error' => $e->getMessage(),
                    'code_error' => 500,
                    'userIsAuthenticate' => authentification\AuthenticateService::isAuthenticate(), // Vérifier si l'utilisateur est authentifié
                ]
            );
        }
        
    }
}