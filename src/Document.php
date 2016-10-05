<?php

namespace Iivannov\ElasticCommander;

class Document
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


    public function __construct(\Elasticsearch\Client $client, $index, $type)
    {
        $this->client = $client;
        $this->index = $index;
        $this->type = $type;
    }




    public function exists($id)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
        ];

        return $this->client->exists($params);
    }

    public function get($id)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id
        ];

        return $this->client->get($params);
    }

    public function delete($id)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id
        ];

        return $this->client->delete($params);
    }


    public function add($id, $params)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
            'body' => $params
        ];

        $response = $this->client->index($params);

        return (bool) isset($response['created']) && $response['created'];
    }

    public function update($id, $params)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
            'body' => ['doc' => $params]
        ];

        $response = $this->client->update($params);

        return (bool)isset($response['created']) && $response['created'];
    }


}