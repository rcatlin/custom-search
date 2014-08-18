<?php

namespace RCatlin\CustomSearch;

use RCatlin\CustomSearch\Autocomplete\Client\RestClient as AutocompleteRestClient;
use RCatlin\CustomSearch\Autocomplete\Query\Builder as AutocompleteQueryBuilder;
use RCatlin\CustomSearch\Search\Client\RestClient as SearchRestClient;
use RCatlin\CustomSearch\Search\Query\Builder as SearchQueryBuilder;

class Manager
{
    /**
     * Custom Search ID
     * @var string
     */
    protected $cx;

    /**
     * Array of project api keys
     * @var array
     */
    protected $apiKeys;

    /**
     * @var \RCatlin\CustomSearch\ClientInterface
     */
    protected $searchClient;

    /**
     * @var \RCatlin\CustomSearch\ClientInterface
     */
    protected $autocompleteClient;

    public function __construct(
        $cx,
        array $apiKeys = array(),
        $searchClient = null,
        $autocompleteClient = null
    )
    {
        $this->cx = $cx;

        if (!is_array($apiKeys) || empty($apiKeys)) {
            throw \Exception('The API Keys argument must be an array with at least one key.');
        }

        $this->apiKeys = $apiKeys;

        // Create the default search client if client none provided
        if ($searchClient === null) {
            $searchClient = $this->createDefaultSearchClient();
        }

        // Create the default autocomplete client if none provided
        if ($autocompleteClient === null) {
            $autocompleteClient = $this->createDefaultAutocompleteClient();
        }

        $this->searchClient = $searchClient;
        $this->autocompleteClient = $autocompleteClient;
    }

    /**
     * @param  string $query
     * @return mixed
     */
    public function search($searchTerms)
    {
        $apiKey = $this->getApiKey();

        return $this->createSearchQueryBuilder()
            ->setCx($this->cx)
            ->setSearchTerms($searchTerms)
            ->getQuery()
            ->setClient($this->searchClient)
            ->execute()
        ;
    }

    /**
     * @param  string $query
     * @return mixed
     */
    public function autocomplete($searchTerms)
    {
        return $this->createSearchQueryBuilder()
            ->setPartnerId($this->cx)
            ->setSearchTerms($searchTerms)
            ->getQuery()
            ->setClient($this->autocompleteClient)
            ->execute()
        ;
    }

    /**
     * @return \RCatlin\CustomSearch\Search\Query\Builder
     */
    protected function createSearchQueryBuilder()
    {
        return new SearchQueryBuilder();
    }

    /**
     * @return \RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    protected function createAutocompleteQueryBuilder()
    {
        return new AutocompleteQueryBuilder();
    }

    /**
     * @return \RCatlin\CustomSearch\Search\Client\RestClient
     */
    protected function createDefaultSearchClient()
    {
        return new SearchRestClient();
    }

    /**
     * @return \RCatlin\CustomSearch\Search\Client\RestClient
     */
    protected function createDefaultAutocompleteClient()
    {
        return new AutocompleteRestClient();
    }

    protected function getApiKey()
    {
        $numKeys = count($this->apiKeys);

        if ($numKeys === 1) {
            return $this->apiKeys[0];
        }

        return $this->keys[mt_rand(0, $numKeys - 1)];
    }
}
