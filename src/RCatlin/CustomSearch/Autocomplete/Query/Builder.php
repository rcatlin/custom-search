<?php

namespace RCatlin\CustomSearch\Autocomplete\Query;

class Builder
{
    CONST ENCODING_UTF8 = 'utf8';

    /**
     * Defaults to 'partner'
     */
    private $client = 'partner';

    /**
     * Default home language is english
     */
    private $homeLanguage= 'en';

    private $partnerId;

    /**
     * Defaults to Custom Search Engine
     */
    private $ds = 'cse';

    /**
     * Defaults to JSON return type
     */
    private $returnType = 'json';

    private $searchTerms;

    /**
     * Character encoding that is used to interpret the query string.
     * Default is UTF-8
     *
     * Full list of character encoding values:
     * https://developers.google.com/search-appliance/documentation/50/xml_reference#CharacterEncodingValues
     */
    private $inputEncoding = self::ENCODING_UTF8;

    /**
     * Character encoding that is used to encode the results.
     * Default is UTF-8
     *
     * Full list of character encoding values:
     * https://developers.google.com/search-appliance/documentation/50/xml_reference#CharacterEncodingValues
     */
    private $outputEncoding = self::ENCODING_UTF8;

    // dictionary: query-name => variable-name
    private $parameterMap = array(
        'client'    => 'client',
        'hl'        => 'homeLanguage',
        'partnerid' => 'partnerId',
        'ds'        => 'ds',
        'q'         => 'searchTerms',
        'ie'        => 'inputEncoding',
        'oe'        => 'outputEncoding'
    );

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setHomeLanguage($homeLanguage)
    {
        $this->homeLanguage = $homeLanguage;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setDs($ds)
    {
        $this->ds = $ds;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    // TODO Support alternate return types
    // public function setReturnType($returnType)
    // {
    //     $this->returnType = $returnType;

    //     return $this;
    // }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setSearchTerms($searchTerms)
    {
        $this->searchTerms = $searchTerms;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setInputEncoding($inputEncoding)
    {
        $this->inputEncoding = $inputEncoding;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplete\Query\Builder
     */
    public function setOutputEncoding($outputEncoding)
    {
        $this->outputEncoding = $outputEncoding;

        return $this;
    }

    /**
     * @return RCatlin\CustomSearch\Autocomplet\Query\Query
     */
    public function getQuery()
    {
        $params = array();
        foreach ($this->parameterMap as $key => $name) {
            if (isset($this->$name) && $this->$name !== null) {
                $params[] = $key . '=' . urlencode($this->$name);
            }
        }

        if (isset($this->returnType)) {
            $params[] = $this->returnType . '=' . 'true';
        }

        $queryString = '?' . implode('&', $params);

        return new Query($queryString);
    }
}
