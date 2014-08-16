<?php

namespace RCatlin\CustomSearch\Search;

class JsonResponse
{
    private $data;

    private $queries = null;
    private $request = null;
    private $error = null;
    private $items = null;
    private $pagemaps = null;
    private $offset = null;
    private $totalResults = null;
    private $nextPage = null;
    private $nextOffset = null;

    public function __construct($json)
    {
        $this->data = json_decode($json);
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function getQueries()
    {
        if (
            $this->queries === null
            && isset($this->data['queries'])
        ) {
            $this->queries = $this->data['queries'];
        }

        return $this->queries;
    }

    /**
     * @return array|null
     */
    public function getRequest()
    {
        if (
            $this->request === null
            && ($queries = $this->getQueries()) !== null
            && isset($queries['request'])
        ) {
            $this->request = array_shift($queries['request']);
        }

        return $this->request;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        if (
            $this->error === null
            && isset($this->data['error'])
        ) {
            $this->error = $this->data['error'];
        }

        return $this->error;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return ($this->getError() !== null);
    }

    /**
     * @return array|null
     */
    public function getItems()
    {
        if (
            $this->items === null
            && isset($this->data['items'])
        ) {
            $this->items = $this->data['items'];
        }

        return $this->items;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        if (
            $this->offset === null
            && $request = $this->getRequest()) !== null
            && isset($request['startIndex']
        ) {
            $this->offset = $request['startIndex'];
        }

        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function getTotalResults()
    {
        if (
            $this->totalResults === null
            && ($request = $this->getRequest()) !== null
            && isset($request['totalResults'])
        ) {
            $this->totalResults = $request['totalResults'];
        }

        return $this->totalResults;
    }

    /**
     * Gets 'nextPage' value from first  array within 'queries'
     * @return array|null
     */
    public function getNextPage()
    {
        if (
            $this->nextPage === null) {
            && ($queries = $this->getQueries()) !== null
            && isset($queries['nextPage'])
        ) {
            $this->nextPage = array_shift($queries['nextPage']);
        }

        return $this->nextPage;
    }

    /**
     * @return bool
     */
    public function hasNextPage()
    {
        return ($this->hasNextPage() !== null);
    }

    /**
     * @return int|null
     */
    public function getNextOffset()
    {
        if (
            $this->nextOffset === null
            && ($nextPage = $this->getNextPage()) !== null
            && isset($nextPage['startIndex'])
        ) {
            $this->nextOffset = $nextPage['startIndex'];
        }

        return $this->nextOffset;
    }

    /**
     * Parses all items for pagemap data
     * @return array|null
     */
    public function getPagemaps()
    {
        if (
            $this->pagemaps === null
            && ($items = $this->getItems()) !== null
        ) {
            $this->pagemaps = array();
            foreach ($items as $item) {
                if (!isset($item['pagemap'])) {
                    continue;
                }
                $this->pagemaps[] = $item['pagemap'];
            }
        }

        return $this->pagemaps;
    }
}
