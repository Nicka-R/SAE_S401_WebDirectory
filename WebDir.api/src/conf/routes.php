<?php
declare(strict_types=1);

use web\directory\api\app\actions\GetDefaultAction;
use web\directory\api\app\actions as Actions;



return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class)->setName('home');

    //route pour accéder aux services
    $app->get('/api/services', Actions\GetServices::class)->setName('services');

    //route pour accéder aux services
    $app->get('/api/departements', Actions\GetDepartements::class)->setName('departements');
    
    //route pour accéder aux entrées
    $app->get('/api/entrees', Actions\GetEntreesAction::class)->setName('entrees');

    // route pour accéder au services par entree
    $app->get('/api/entrees/{id}/services', Actions\ServiceByEntreeAction::class)->setName('servicesByEntree');

    //route pour accéder aux entrées par service
    $app->get('/api/services/{id}/entrees', Actions\EntreesByService::class)->setName('entreesByService');

    //route pour accéder aux entrées par nom
    $app->get('/api/entrees/search', Actions\GetEntreesByCritere::class)->setName('entreesByNom');

    //route pour accéder à une entrée donnée
    $app->get('/api/entrees/{id}', Actions\EntreeById::class)->setName('entree');

   
    return $app;
};