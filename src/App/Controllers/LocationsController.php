<?php

namespace App\Controllers;

use App\Services\LocationsService;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationsController
{
    private $app;
    private $locationsService;

    public function __construct(Application $application, LocationsService $locationsService)
    {
        $this->app = $application;
        $this->locationsService = $locationsService;
    }

    public function getLocation($mediaId)
    {
        $result = $this->locationsService->getLocationInfo($mediaId);
        return $this->buildResponse($result);
    }

    private function buildResponse($result)
    {
        $location = $this->buildLocationJson($result);
        return JsonResponse::create($location, $result['meta']['code'], array('Content-Type' => 'application/json'));
    }

    private function buildLocationJson($result)
    {
        $location = null;
        $id = null;
        $status = null;
        $jsonArray = [];
        if (is_null($result)) {
            return array('STATUS' => 500);
        }
        if (isset($result['data'])) {
            if (isset($result['data']['location'])) {
                $location = $result['data']['location'];
                $jsonArray['location'] = $location;
            }
            if (isset($result['data']['id'])) {
                $id = $result['data']['id'];
                $jsonArray['id'] = $id;
            }
        }
        if (isset($result['meta']['code'])) {
            $status = $result['meta']['code'];
        } else {
            $status = 500;
        }
        $jsonArray['STATUS'] = $status;

        return $jsonArray;
    }
}