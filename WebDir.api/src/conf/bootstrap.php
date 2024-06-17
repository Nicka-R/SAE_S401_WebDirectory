<?php

use \Slim\Factory\AppFactory;
use web\directory\api\infrastructure\utils\Eloquent;

/* Initialisation de la base de donnée */
Eloquent::init(__DIR__ . '/webdir.db.conf.ini.dist');

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

// CORS
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Charger les routes
$app = (require_once __DIR__ . '/routes.php')($app);

session_start();

return $app;
