<?php

namespace App\Config;

use App\Controllers\LocationsController;
use App\Services\LocationsService;
use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;

class Bootstrap
{
    static public function init(Application $app)
    {
        $app->register(new ServiceControllerServiceProvider());

        $app['locations.controller'] = $app->share(function () use ($app) {
            return new LocationsController($app, $app['locations.service']);
        });

        $app['locations.service'] = $app->share(function () use ($app) {
            return new LocationsService();
        });

        $app->get('/', function () {
            return "API is UP";
        });
        //$app->get('/locations', "locations.controller:getHome");
        $app->get('/locations/{mediaId}', "locations.controller:getLocation");
    }
}