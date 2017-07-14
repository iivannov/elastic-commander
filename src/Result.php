<?php

namespace Iivannov\ElasticCommander;


class Result
{

    protected $response;

    protected $size;

    protected $from;


    /**
     * @param $response
     * @return self
     */
    public function setResponse($response, $size, $from)
    {
        $this->response = $response;
        $this->size = $size;
        $this->from = $from;

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
     * Return the total number of hits
     *
     * @return int
     */
    public function total()
    {
        if (!$this->response)
            return 0;

        return $this->response['hits']['total'];
    }

    /**
     * Return the current page
     *
     * @return int
     */
    public function page()
    {
        if (!$this->from) {
            return 1;
        }

        if ($this->from % $this->size > 0) {
            throw new \RuntimeException('The offset is not multiple of the size, thus making the page calculation not accurate');
        }

        return (int)($this->from / $this->size) + 1;
    }


    /**
     * Return just the ids of the hits
     *
     * @return array
     */
    public function ids()
    {
        $ids = [];

        foreach ($this->response['hits']['hits'] as $hit) {
            $ids[] = $hit['_id'];
        }

        return $ids;
    }

    /**
     * Return an array of the hits as objects
     *
     * @return array
     */
    public function hits()
    {
        $hits = [];
        foreach ($this->response['hits']['hits'] as $hit) {
            $object = (object)$hit['_source'];
            $object->sort = isset($hit['sort']) ? reset($hit['sort']) : null;
            $hits[$hit['_id']] = $object;
        }

        return $hits;
    }

}