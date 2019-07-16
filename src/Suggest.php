<?php

namespace Iivannov\ElasticCommander;

class Suggest
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
     * The result of the executed query
     *
     * @var SuggestResult
     */
    protected $result;


    public function __construct(\Elasticsearch\Client $client, $index, $type)
    {
        $this->client = $client;
        $this->index = $index;
        $this->type = $type;

        $this->result = new SuggestResult();
    }

    /**
     * Performa a suggest query
     *
     * @param $prefix
     * @param $field
     * @param int $size
     * @return SuggestResult
     */
    public function query($prefix, $field, $size = 5)
    {
        $response = $this->client->search([
            'index' => $this->index,
            'type'  => $this->type,
            'body'  => [
                'suggest' => [
                    'results' => [
                        'prefix'     => $prefix,
                        'completion' => [
                            'field' => $field,
                            'size'  => $size
                        ]
                    ]
                ]
            ]
        ]);

        return $this->result->setResponse($response);
    }

}