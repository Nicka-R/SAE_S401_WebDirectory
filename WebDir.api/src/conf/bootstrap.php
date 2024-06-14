<?php

use \Slim\Factory\AppFactory;
use web\directory\infrastructure\utils\Eloquent;

/* Initialisation de la base de donnée */
Eloquent::init(__DIR__ . '/webdir.db.conf.ini.dist');

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app = (require_once __DIR__ . '/routes.php')($app);


session_start();

return $app;