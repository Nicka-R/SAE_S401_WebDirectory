<?php

use \Slim\Factory\AppFactory;
use web\directory\infrastructure\utils\Eloquent;
use Twig\Extension\DebugExtension;


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app = (require_once __DIR__ . '/routes.php')($app);

define('BASE_PATH', dirname(__DIR__, 2)); // Remonte deux niveaux pour atteindre WebDir.core

// Utiliser cette constante pour définir le chemin vers user-img
$userImgDir = BASE_PATH . '/src/user-img/';

/* Initialisation de la base de donnée */
Eloquent::init(__DIR__ . '/webdir.db.conf.ini.dist');

$twig = \Slim\Views\Twig::create(
    'src/app/views/',
    [
        'debug' => true,
        'auto_reload' => true,
        'strict_variables' => true
    ]
);

$app->add(\Slim\Views\TwigMiddleware::create($app, $twig));

$twig->getEnvironment()
    ->addGlobal('globals', [
        'css_dir' => 'src/css'
    ]);

$twig->getEnvironment()
    ->addGlobal('global', [
        'img_css_dir' => 'src/css-img'
]);

session_start();

return $app;