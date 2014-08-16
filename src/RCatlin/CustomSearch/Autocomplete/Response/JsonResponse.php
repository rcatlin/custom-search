<?php

namespace RCatlin\CustomSearch\Autocomplete\Response;

/**
 * Example data array:
 * array(
 *      "sho",
 *      array(
 *          "shoes",
 *          "shower curtains",
 *          "showe clip"
 *      )
 * )
 */
class JsonResponse
{
    private $data;

    private $query = null;
    private $completions = null;

    public function __construct($json)
    {
        $this->data = json_decode($json, true);
    }

    public function getQuery()
    {
        if ($this->query === null) {
            if (isset($this->data[0])) {
                $this->query = $this->data[0];
            }
        }

        return $this->query;
    }

    public function getCompletions()
    {
        if ($this->completions === null) {
            if (isset($this->data[1])) {
                $this->completions = $this->data[1];
            }
        }

        return $this->completions;
    }

    public function getAll()
    {
        return array(
            'query' => $this->getQuery(),
            'completions' => $this->getCompletions()
        );
    }

    public function hasCompletions()
    {
        return (count($this->getCompletions()) > 0);
    }
}
