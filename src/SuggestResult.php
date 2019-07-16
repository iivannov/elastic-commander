<?php

namespace Iivannov\ElasticCommander;


class SuggestResult
{
    protected $response;

    /**
     * @param $response
     * @return self
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Return the raw response
     *
     * @return mixed
     */
    public function response()
    {
        return $this->response;
    }


    /**
     * Return just the ids of the suggestions
     *
     * @return array
     */
    public function ids(): array
    {
        $results = [];
        foreach ($this->getSuggestions() as $suggestion) {
            $results[] = $suggestion['_id'];
        }

        return $results;
    }

    /**
     * Return an array of the suggestions as strings
     *
     * @return array
     */
    public function results(): array
    {
        $results = [];
        foreach ($this->getSuggestions() as $suggestion) {
            $results[] = $suggestion['text'];
        }

        return $results;
    }

    protected function getSuggestions()
    {
        return current($this->response['suggest']['results'])['options'];
    }

}