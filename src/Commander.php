<?php

namespace Iivannov\ElasticCommander;

use Elasticsearch\ClientBuilder;

class Commander
{

    /**
     * ElasticSearch Client instance
     *
     * @var \Elasticsearch\Client
     */
    protected $client;

    /**
     * The name of the index currently used
     *
     * @var string
     */
    protected $indexName;


    protected $index;

    protected $document;

    protected $search;

    protected $count;

    public function __construct($indexName, $hosts = [], $handler = null)
    {
        $this->indexName = $indexName;

        $builder = ClientBuilder::create();

        if ($hosts) {
            $builder->setHosts($hosts);
        }

        if ($handler) {
            $builder->setHandler($handler);
        }

        $this->client = $builder->build();
    }


    public function reset($indexName)
    {
        $this->indexName = $indexName;

        $this->index = null;
        $this->search = null;
        $this->document = null;
        $this->count = null;

        return $this;
    }

    public function index()
    {
        if ($this->index == null)
            $this->index = new Index($this->client, $this->indexName);

        return $this->index;
    }

    public function document($type)
    {
        if ($this->document == null)
            $this->document = new Document($this->client, $this->indexName, $type);

        return $this->document;
    }

    public function search($type)
    {
        if ($this->search == null)
            $this->search = new Search($this->client, $this->indexName, $type);

        return $this->search;
    }

    public function count($type)
    {
        if ($this->count == null)
            $this->count = new Count($this->client, $this->indexName, $type);

        return $this->count;
    }

    public function mapping($mapping)
    {
        $this->client->indices()->putMapping($mapping);
    }


}

