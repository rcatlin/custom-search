<?php

namespace RCatlin\CustomSearch\Tests;

use RCatlin\CustomSearch\RestClient;

class RestClientTest extends CustomSearchTestCase
{
    public function testExecute()
    {
        $ch = new \stdClass();
        $baseUrl = "http://base-url.edu";
        $queryString = "?q=awesome+possum";
        $response = "This is the response. Pretty boring, eh?";
        $httpCode = 200;

        $client = $this->createStubClient($baseUrl)
            ->setHandle($ch)
            ->setResponse($response)
            ->setHttpCode($httpCode)
        ;

        $result =  $client->execute($queryString);

        $expectation = array(
            'url' => $baseUrl . $queryString,
            'method' => 'GET',
            'status' => $httpCode,
            'response' => $response
        );

        $this->assertEquals(
            $result,
            $expectation
        );
    }

    protected function createStubClient($baseUrl)
    {
        return new RestClientStub($baseUrl);
    }
}

class RestClientStub extends RestClient
{
    private $ch;
    private $response;
    private $httpCode;

    public function setHandle($ch)
    {
        $this->ch = $ch;

        return $this;
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    protected function initHandle($url, $method)
    {
        return $this->ch;
    }

    protected function execHandle($ch)
    {
        return $this->response;
    }

    protected function getHandleHttpCode($ch)
    {
        return $this->httpCode;
    }

    protected function closeHandle($ch)
    {
    }
}
