<?php
declare(strict_types=1);

use web\directory\app\actions\GetDefaultAction;
use web\directory\app\actions as Action;

return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class);

    $app->get('/form/create/person',Action\GetFormCreatePersonAction::class)->setName('create_person');

    $app->post('/form/create/person',Action\PostFormCreatePersonAction::class);

    $app->get('/form/create/departement',Action\GetFormCreateDepartementAction::class)->setName('create_departement');

    $app->post('/form/create/departement',Action\PostFormCreateDepartementAction::class);

    $app->get('/form/create/service',Action\GetFormCreateServiceAction::class)->setName('create_service');

    $app->post('/form/create/service',Action\PostFormCreateServiceAction::class);

    $app->get('/view/entree',Action\GetListEntreeAction::class)->setName('view_entree');

    $app->post('/view/entree',Action\PostListEntreeAction::class);

    $app->get('/account/login',Action\GetLoginAction::class)->setName('account_login');

    $app->post('/account/login',Action\PostLoginAction::class);

    $app->get('/account/register',Action\GetRegisterAction::class)->setName('account_register');

    $app->post('/account/register',Action\PostRegisterAction::class);

    $app->get('/account/logout',Action\GetLogoutAction::class)->setName('account_logout');




   
    return $app;
};