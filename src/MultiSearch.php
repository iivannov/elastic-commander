<?php

namespace Iivannov\ElasticCommander;

class MultiSearch
{

    /**
     * ElasticSearch Client instance
     *
     * @var \Elasticsearch\Client
     */
    protected $client;

    public function __construct(\Elasticsearch\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Executes a custom ElasticSearch query
     *
     * @param $query
     * @return array|Result[]
     */
    public function query($query): array
    {
        $responses = $this->search($query);

        $results = [];
        foreach ($responses['responses'] as $response) {
            $results[] = new Result($response);
        }

        return $results;
    }

    /**
     * Performs the search by the given parameters
     *
     * @param $body
     * @return array
     */
    private function search($body)
    {
       return $this->client->msearch([
            'body' => $body,
        ]);
    }


}