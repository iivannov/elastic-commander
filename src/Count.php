<?php

namespace Iivannov\ElasticCommander;

use Iivannov\ElasticCommander\Contracts\CriteriaInterface;

class Count
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


    protected $response;

    public function __construct(\Elasticsearch\Client $client, $index, $type)
    {
        $this->client = $client;
        $this->index = $index;
        $this->type = $type;
    }


    public function response()
    {
        return $this->response;
    }

    public function total() {

        if(!$this->response)
            return 0;

        return $this->response['count'] ?? 0;
    }



    public function query($query)
    {
        $this->response = $this->count($query);

        return $this;
    }


    public function criteria(CriteriaInterface $criteria)
    {
        $this->response = $this->count(
            $criteria->query()
        );

        return $this;
    }


    /**
     * Performs the search by the given parameters
     *
     * @param $query
     * @param $sort
     * @param $size
     * @param $from
     * @param $body
     */
    private function count($query)
    {
        $body['query'] = $query;

        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => $body
        ];

        return $this->client->count($params);
    }


}