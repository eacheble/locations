<?php

use Silex\Application;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

\App\Bootstrap\Bootstrap::init($app);

$app->run();