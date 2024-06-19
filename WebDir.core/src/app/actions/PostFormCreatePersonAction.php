<?php

namespace web\directory\app\actions;

use web\directory\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use web\directory\core\services\userDataManagementService\UserDataManagementService;
use web\directory\core\services\userData\UserDataService;
use web\directory\core\services\userDataManagementService\UserDataManagementException;
use web\directory\core\services\annuaire\AnnuaireService;
use web\directory\app\utils\CsrfService;
use web\directory\core\services\authentification\AuthenticateService;
use Slim\Views\Twig;

class PostFormCreatePersonAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $twig = Twig::fromRequest($request);
        $userService = new UserDataService();
        $userDataManager = new UserDataManagementService();
        $annuaireService = new AnnuaireService();

        try {
            // check csrf token
            $data = $request->getParsedBody();
            if (!isset($data['csrf_token']) || !CsrfService::check('person', $data['csrf_token'])) {
                throw new \Exception('Les données du formulaires ont étés détéctées comme suspectes, il s\'agit peut-être d\'un rechargement de la page, veuillez réessayer.');
            }

            //form data
            $data = $request->getParsedBody();
            $files = $request->getUploadedFiles();

            // Ajout des fichiers à la data
            $data['files'] = $files;

            $userDataManager->addPerson($data);

            return $twig->render(
                $response,
                'form_create_person.html.twig',
                [
                    'message' => "Utilisateur crée avec succès",
                    'csrf_token' => CsrfService::generate('person'),
                    'services' => $userService->getServices(),
                    'departements' => $annuaireService->getDepartements(),
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate()
                ]
            );

        } catch (UserDataManagementException $e) {
            return $twig->render(
                $response,
                'form_create_person.html.twig',
                [
                    'message' => $e->getMessage(),
                    'csrf_token' => CsrfService::generate('person'),
                    'services' => $userService->getServices(),
                    'departements' => $annuaireService->getDepartements(),
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate()
                ]
            );

        } catch (\Exception $e) {
            return $twig->render(
                $response,
                'form_create_person.html.twig',
                [
                    'message' => "Problème avec le serveur",
                    'csrf_token' => CsrfService::generate('person'),
                    'services' => $userService->getServices(),
                    'departements' => $annuaireService->getDepartements(),
                    'userIsAuthenticate' => AuthenticateService::isAuthenticate()
                ]
            );
        }
    }

}