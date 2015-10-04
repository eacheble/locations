<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use Silex\Application;

class LocationsServiceTest extends \PHPUnit_Framework_TestCase
{
    private $locationsService;
    private $client;

    public function setUp()
    {
        $this->locationsService = new LocationsService();
    }

    public function testGetMediaInfoSuccess()
    {
        $json_file = file_get_contents(__DIR__ . "/" . "/../../resources/responseEmptyLocation.json");
        $stream = Stream::factory($json_file);
        $mock = new Mock([
            new Response(200, ['Content-Type' => 'application/json'], $stream)
        ]);
        $this->client = new Client();
        $this->client->getEmitter()->attach($mock);
        $this->locationsService->setClient($this->client);

        $response = $this->locationsService->getLocationInfo('id');

        $this->assertNotEmpty($response);
        $this->assertEquals(200, $response['meta']['code']);
    }

    public function testGetMediaInfoBadRequest()
    {
        $json_file = file_get_contents(__DIR__ . "/" . "/../../resources/error.json");
        $stream = Stream::factory($json_file);
        $mock = new Mock([
            new Response(400, ['Content-Type' => 'application/json'], $stream)
        ]);
        $this->client = new Client();
        $this->client->getEmitter()->attach($mock);
        $this->locationsService->setClient($this->client);

        $response = $this->locationsService->getLocationInfo('id');

        $this->assertNotEmpty($response);
        $this->assertEquals(400, $response['meta']['code']);
        $this->assertNotEmpty($response['meta']['error_message']);
    }
}