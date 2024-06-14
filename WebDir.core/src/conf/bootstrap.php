<?php

use \Slim\Factory\AppFactory;
use web\directory\infrastructure\utils\Eloquent;


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app = (require_once __DIR__ . '/routes.php')($app);

/* Initialisation de la base de donnée */
Eloquent::init(__DIR__ . '/webdir.db.conf.ini.dist');

$twig = \Slim\Views\Twig::create(
    'src/app/views/',
    [/*'cache' => './src/app/views/cache',*/
        'auto_reload' => true,
        'strict_variables' => true
    ]
);

$app->add(\Slim\Views\TwigMiddleware::create($app, $twig));

session_start();

return $app;