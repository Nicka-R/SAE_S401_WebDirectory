<?php
declare(strict_types=1);

use web\directory\api\app\actions\GetDefaultAction;
use web\directory\api\app\actions as Actions;



return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class)->setName('home');

    //route pour accéder aux services
    $app->get('/api/services', Actions\GetServices::class)->setName('services');
    //route pour accéder aux entrées
    $app->get('/api/entrees', Actions\GetEntreesAction::class)->setName('entrees');
   
    return $app;
};