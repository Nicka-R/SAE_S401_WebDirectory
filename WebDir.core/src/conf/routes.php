<?php
declare(strict_types=1);

use web\directory\app\actions\GetDefaultAction;

return function (\Slim\App $app): \Slim\App {

    //Route par défaut
    $app->get('/', GetDefaultAction::class);
   
    return $app;
};