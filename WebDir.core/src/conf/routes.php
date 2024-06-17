<?php
declare(strict_types=1);

use web\directory\app\actions\GetDefaultAction;
use web\directory\app\actions\GetFormCreatePerson;

return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class);

    $app->get('/form/create/person',GetFormCreatePerson::class)->setName('create_person');
   
    return $app;
};