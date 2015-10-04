<?php

namespace App\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class LocationsController implements ControllerProviderInterface
{
    private $locations = array(
        '00001'=> array(
            'name' => 'Remote Control Car',
            'quantity' => '53',
            'description' => '...',
            'image' => 'racing_car.jpg',
        ),
        '00002' => array(
            'name' => 'Raspberry Pi',
            'quantity' => '13',
            'description' => '...',
            'image' => 'raspberry_pi.jpg',
        ),
    );
    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return \Silex\ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $factory = $app['controllers_factory'];

        $factory->get('/', 'App\Controllers\LocationsController::getHome');
        $factory->get('/{mediaId}', 'App\Controllers\LocationsController::getMediaLocation');

        return $factory;
    }

    public function getHome(Application $app)
    {
        return json_encode($this->locations);
    }

    public function getMediaLocation(Application $app, $mediaId)
    {
        if (!isset($this->locations[$mediaId])) {
            $app->abort(404, "media {$mediaId} does not exist.");
        }
        return json_encode($this->locations[$mediaId]);
    }
}