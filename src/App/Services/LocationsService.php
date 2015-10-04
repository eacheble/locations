<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Silex\Application;

class LocationsService
{
    private $instagramMediaPath = "https://api.instagram.com/v1/media/%s";
    private $instagramAppClientID;
    private $client;

    public function getClient()
    {
        return $this->client;
    }
    public function setClient($client)
    {
        $this->client = $client;
    }

    public function __construct()
    {
        $this->client = new Client();
        $app_config_file = parse_ini_file(__DIR__ . "/" . "/../resources/config.ini");
        $this->instagramAppClientID = $app_config_file['CLIENT_ID'];
    }

    public function getLocationInfo($mediaId)
    {
        $uri = $this->buildRequestURI($this->instagramMediaPath, $mediaId);
        try {
            $response = $this->client->get($uri, ['query' => ['client_id' => $this->instagramAppClientID]]);
            return $response->json();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->json();
            } else {
                return null;
            }
        }
    }

    private function buildRequestURI($baseURI, $id)
    {
        return sprintf($baseURI, $id);
    }
}