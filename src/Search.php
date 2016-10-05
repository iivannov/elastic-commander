<?php

namespace Iivannov\ElasticCommander;

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

        return $this->response['hits']['total'];
    }

    public function ids() {

        $ids = [];
        foreach ($this->response['hits']['hits'] as $hit) {
            $ids[] = $hit['_id'];
        }

        return $ids;
    }

    public function hits() {

        $hits = [];
        foreach ($this->response['hits']['hits'] as $hit) {
            $object = (object) $hit['_source'];
            $object->sort = reset($hit['sort']);
            $hits[$hit['_id']] = $object;
        }

        return $hits;
    }



    public function query($query, $sort = null, $size = 20, $from = 0)
    {
        $body['query'] = $query;

        if($sort)
            $body['sort'] = $sort;

        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => $body,
            'size' => $size,
            'from' => $from
        ];

        $this->response = $this->client->search($params);

        return $this;
    }




}