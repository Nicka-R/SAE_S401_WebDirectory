<?php
declare(strict_types=1);

use web\directory\app\actions\GetDefaultAction;
use web\directory\app\actions as Action;

return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class);

    $app->get('/form/create/person',Action\GetFormCreatePersonAction::class)->setName('create_person');

    $app->post('/form/create/person',Action\PostFormCreatePersonAction::class);

   
    return $app;
};