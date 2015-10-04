<?php

namespace App\Controllers;

use Silex\Application;

class LocationsControllerTest extends \PHPUnit_Framework_TestCase
{
    private $app;
    private $locationsService;
    private $locationsController;


    public function setUp()
    {
        $this->app = new Application();
        $this->locationsService = $this->getMock(\App\Services\LocationsService::class);
        $this->locationsController = new LocationsController($this->app, $this->locationsService);
    }

    public function testRequestWithInvalidIdReturnsBadRequest()
    {
        $result = json_decode(file_get_contents(__DIR__ . "/" . "/../../resources/error.json"), true);
        $this->locationsService->expects($this->any())->method('getLocationInfo')->will($this->returnValue($result));
        $response = array('STATUS'=>400);

        $actual_response = $this->locationsController->getLocation($this->any());

        $this->assertNotEmpty($actual_response);
        $this->assertEquals(400, $actual_response->getStatusCode());
        $this->assertEquals(json_encode($response), $actual_response->getContent());
    }

    public function testRequestWithValidIdReturnsEmptyLocationInfo()
    {
        $result = json_decode(file_get_contents(__DIR__ . "/" . "/../../resources/responseEmptyLocation.json"), true);
        $this->locationsService->expects($this->any())->method('getLocationInfo')->will($this->returnValue($result));
        $response = array('id'=>'4_3', 'STATUS'=>200);

        $actual_response = $this->locationsController->getLocation($this->any());

        $this->assertNotEmpty($actual_response);
        $this->assertEquals(200, $actual_response->getStatusCode());
        $this->assertEquals(json_encode($response), $actual_response->getContent());
    }

    public function testRequestWithValidIdReturnsLocationInfo()
    {
        $result = json_decode(file_get_contents(__DIR__ . "/" . "/../../resources/response.json"), true);
        $this->locationsService->expects($this->any())->method('getLocationInfo')->will($this->returnValue($result));

        $location = array(
            'latitude'=> -6.88333,
            'name'=> "Pekalongan, Indonesia",
            'longitude'=> 109.667,
            'id'=> 368852475
        );
        $response = array('location'=>$location, "id"=>"4_3", 'STATUS'=>200);

        $actual_response = $this->locationsController->getLocation($this->any());

        $this->assertNotEmpty($actual_response);
        $this->assertEquals(200, $actual_response->getStatusCode());
        $this->assertEquals(json_encode($response), $actual_response->getContent());
    }
}