<?php

namespace RCatlin\CustomSearch\Tests;

use RCatlin\CustomSearch\Manager;
use RCatlin\CustomSearch\Search\Query\Builder as SearchQueryBuilder;
use RCatlin\CustomSearch\Autocomplete\Query\Builder as AutocompleteQueryBuilder;

class ManagerTest extends CustomSearchTestCase
{
    private $cx = 'custom-search-id';
    private $apiKey = 'api-key';
    private $searchClient;
    private $autocompleteClient;

    /**
     * @var \RCatlin\CustomSearch\Manager
     */
    private $manager;

    public function setUp()
    {
        // Mocks
        $this->searchClient = $this->buildMock('RCatlin\CustomSearch\Search\Client\RestClient');
        $this->autocompleteClient = $this->buildMock('RCatlin\CustomSearch\Autocomplete\Client\RestClient');

        // Object to test
        $this->manager = new ManagerStub(
            $this->cx,
            array($this->apiKey),
            $this->searchClient,
            $this->autocompleteClient
        );
    }

    public function testSearch()
    {
        // Relevant Data
        $searchTerms = "shark morphology";

        // Mocks
        $builder = $this->buildMock('RCatlin\CustomSearch\Search\Query\Builder');
        $query = $this->buildMock('RCatlin\CustomSearch\Search\Query\Query');
        $response = array('this', 'is', 'the', 'response!');

        // Set mock on stub
        $this->manager->setSearchQueryBuilder($builder);

        // Expectations
        $builder->expects($this->once())
            ->method('setCx')
            ->with($this->cx)
            ->will($this->returnValue($builder))
        ;

        $builder->expects($this->once())
            ->method('setSearchTerms')
            ->with($query)
            ->will($this->returnValue($builder))
        ;

        $builder->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query))
        ;

        $query->expects($this->once())
            ->method('setClient')
            ->with($this->searchClient)
            ->will($this->returnValue($query))
        ;

        $query->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($response))
        ;

        // Execute method
        $result = $this->manager->search($query);

        // Assert
        $this->assertEquals(
            $result,
            $response
        );
    }
}

class ManagerStub extends Manager
{
    private $searchBuilder;
    private $autocompleteBuilder;

    public function setSearchQueryBuilder(SearchQueryBuilder $builder)
    {
        $this->searchBuilder = $builder;
    }

    public function setAutocompleteQueryBuilder(AutocompleteQueryBuilder $builder)
    {
        $this->autocompleteBuilder = $builder;
    }

    protected function createSearchQueryBuilder()
    {
        return $this->searchBuilder;
    }

    protected function createAutocompleteQueryBuilder()
    {
        return $this->autocompleteBuilder;
    }
}
