<?php
declare(strict_types=1);

use web\directory\app\actions\GetDefaultAction;
use web\directory\app\actions\GetServices;



return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class)->setName('home');

    //route pour accéder aux services
    $app->get('/services', GetServices::class)->setName('services');
   
    return $app;
};