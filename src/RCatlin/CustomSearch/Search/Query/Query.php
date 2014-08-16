<?php

namespace RCatlin\CustomSearch\Search\Query;

use RCatlin\CustomSearch\Search\Client\RestClient;
use RCatlin\CustomSearch\ClientInterface;

class Query
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var RCatlin\CustomSearch\Client\ClientInterface
     */
    private $client = null;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * @return RCatlin\CustomSearch\Search\Query\Query
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if ($this->client === null) {
            $client = new RestClient($query);
        }

        return $client->execute();
    }
}
