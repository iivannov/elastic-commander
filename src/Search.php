<?php

namespace Iivannov\ElasticCommander;

use Iivannov\ElasticCommander\Contracts\CriteriaInterface;

class Search
{

    /**
     * ElasticSearch Client instance
     *
     * @var \Elasticsearch\Client
     */
    protected $client;

    /**
     * Name of the index
     *
     * @var string
     */
    protected $index;

    /**
     * Type of the document
     *
     * @var string
     */
    protected $type;

    /**
     * The number of hits returned
     *
     * @var int
     */
    protected $size;

    /**
     * The result offset
     *
     * @var int
     */
    protected $from;

    /**
     * The result of the executed query
     *
     * @var Result
     */
    protected $result;


    public function __construct(\Elasticsearch\Client $client, $index, $type)
    {
        $this->client = $client;
        $this->index = $index;
        $this->type = $type;

        $this->result = new Result();
    }

    /**
     * Executes a custom ElasticSearch query
     *
     * @param $query
     * @param null $sort
     * @param int $size
     * @param int $from
     * @return Result
     */
    public function query($query, $sort = null, $size = 20, $from = 0)
    {
        $this->size = $size;
        $this->from = $from;;

        $response = $this->search($query, $sort);

        return $this->result->setResponse($response, $this->size, $this->from);
    }

    /**
     * Executes a query based on a given Criteria
     *
     * @param CriteriaInterface $criteria
     * @return Result
     */
    public function criteria(CriteriaInterface $criteria)
    {
        $this->size = $criteria->size();
        $this->from = $criteria->from();

        $response = $this->search(
            $criteria->query(),
            $criteria->sort()
        );

        return $this->result->setResponse($response, $this->size, $this->from);
    }


    /**
     * Performs the search by the given parameters
     *
     * @param $query
     * @param $sort
     */
    private function search($query, $sort)
    {
        $body['query'] = $query;

        if ($sort) {
            $body['sort'] = $sort;
        }

        return $this->client->search([
            'index' => $this->index,
            'type' => $this->type,
            'body' => $body,
            'size' => $this->size,
            'from' => $this->from
        ]);
    }


}