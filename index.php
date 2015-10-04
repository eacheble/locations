<?php

use Silex\Application;
use App\Controllers\LocationsController;

require_once __DIR__.'/vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

$app->get('/', function() {
    return "STATUS IS UP";
});

$app->mount('/locations', new LocationsController());

$app->run();