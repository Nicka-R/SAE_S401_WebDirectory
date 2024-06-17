<?php

    declare(strict_types=1);
    require_once __DIR__ . '/src/vendor/autoload.php'; /* vendor -> autoload */
    $app = require_once __DIR__ . '/src/conf/bootstrap.php'; /* application boostrap */
    $app->run();