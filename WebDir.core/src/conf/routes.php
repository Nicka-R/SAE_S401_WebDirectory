<?php
declare(strict_types=1);

use web\directory\infrastructure\utils\Eloquent;
use web\directory\app\actions\GetDefaultAction;

/* Initialisation de la base de donnée */
Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');


return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class);
   
    return $app;
};