<?php
declare(strict_types=1);

use web\directory\api\app\actions\GetDefaultAction;
use web\directory\api\app\actions\GetServices;



return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class)->setName('home');

    //route pour accéder aux services
    $app->get('/api/services', GetServices::class)->setName('services');
   
    return $app;
};