<?php

namespace Iivannov\ElasticCommander;

class Index
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
    protected $name;


    public function __construct(\Elasticsearch\Client $client, $name)
    {
        $this->client = $client;
        $this->name = $name;
    }

    /**
     * Return the index array for the queries
     *
     * @return array
     */
    public function index()
    {
        return ['index' => $this->name];
    }

    /**
     * Completely resets the index by deleting it
     * and the recreating it
     * @param null $properties
     */
    public function reset($properties = null)
    {
        $this->delete();
        $this->create($properties);
    }

    /**
     * Create an index if it doesn't exist
     * @param null $properties
     */
    public function create($properties = null)
    {
        $index = $this->index();

        if (!$this->client->indices()->exists($index)) {

            if ($properties) {
                $index = array_merge($index, $properties);

            }


            $this->client->indices()->create($index);

        }
    }
    /**
     * Deletes an index
     */
    public function delete()
    {
        $index = $this->index();

        if ($this->client->indices()->exists($index))
            $this->client->indices()->delete($index);
    }


    public function stats($metric = null)
    {
        $params = [
            'index' => $this->name,
            'metric' => $metric
        ];

        return $this->client->indices()->stats($params);
    }


    public function optimize()
    {
        $params = [
            'index' => $this->name,
            'only_expunge_deletes' => true
        ];

        return $this->client->indices()->optimize($params);
    }


}