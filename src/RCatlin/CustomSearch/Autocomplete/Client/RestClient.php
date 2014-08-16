<?php

namespace RCatlin\CustomSearch\Autocomplete\Client;

use RCatlin\CustomSearch\Autocomplete\Response\JsonResponse;
use RCatlin\CustomSearch\RestClient as BaseRestClient;

class RestClient extends BaseRestClient
{
    protected $baseUrl = 'https://www.google.com/complete/search';

    protected function createResponse($url, $method, $statusCode, $response)
    {
        // TODO Detect return types and return relative responses
        return array(
            'url' => $url,
            'method' => $method,
            'status' => $statusCode,
            'response' => new JsonResponse($response)
        );
    }
}
