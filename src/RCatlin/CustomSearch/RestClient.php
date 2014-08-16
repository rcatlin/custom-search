<?php

namespace RCatlin\CustomSearch;

class RestClient extends AbstractClient
{
    /**
     * @param  string $url
     * @param  string $method
     * @return array
     */
    protected function send($url, $method)
    {
        // Get Handle
        $ch = $this->initHandle($url, $method);

        // Get Response
        $response = $this->execHandle($ch);

        // Get Status Code
        $statusCode = $this->getHandleHttpCode($ch);

        // Close Handle
        $this->closeHandle($ch);

        // Return results
        return $this->createResult($url, $method, $statusCode, $response);
    }

    /**
     * @param  string   $url
     * @param  string   $method
     * @return resource $ch
     */
    protected function initHandle($url, $method)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $ch;
    }

    /**
     * @param  resource $ch
     * @return mixed
     */
    protected function execHandle($ch)
    {
        return curl_exec($ch);
    }

    /**
     * @param resource $ch
     *                     @param int
     */
    protected function getHandleHttpCode($ch)
    {
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    /**
     * @param  resource $ch
     * @return null
     */
    protected function closeHandle($ch)
    {
        curl_close($ch);
    }

    /**
     * @param  int   $statusCode
     * @param  mixed $response
     * @return array
     */
    protected function createResult($url, $method, $statusCode, $response)
    {
        return array(
            'url' => $url,
            'method' => $method,
            'status' => $statusCode,
            'response' => $response
        );
    }
}
