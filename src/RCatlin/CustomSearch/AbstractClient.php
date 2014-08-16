<?php

namespace RCatlin\CustomSearch;

abstract class AbstractClient implements ClientInterface
{
    protected $baseUrl = null;

    public function __construct($baseUrl = null)
    {
        if ($baseUrl !== null) {
            if (!is_string($baseUrl)) {
                throw \Exception("Invalid baseUrl. Non-string detected.");
            }

            $this->baseUrl = $baseUrl;
        }
    }

    /**
     * @param  string                      $baseUrl
     * @return RCatlin\CustomSearch\Client
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param  string                            $queryString
     * @return RCatlin\CustomSearch\JsonResponse
     */
    public function execute($queryString)
    {
        if ($this->baseUrl === null) {
            throw \Exception("baseUrl must be set to a url string");
        }

        if ((strpos($queryString, '?')) === FALSE) {
            $queryString = '?' . $queryString;
        }

        return $this->send($this->baseUrl . $queryString, 'GET');
    }

    abstract protected function send($url, $method);
}
