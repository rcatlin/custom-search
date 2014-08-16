<?php

namespace RCatlin\CustomSearch\Search\Client;

use RCatlin\CustomSearch\Search\Response\JsonResponse;
use RCatlin\CustomSearch\RestClient as BaseRestClient;

class RestClient extends BaseRestClient
{
    protected $baseUrl = 'https://www.googleapis.com/customsearch/v1';

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
