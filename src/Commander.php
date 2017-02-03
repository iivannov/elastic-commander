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

    protected $indexName;

    protected $indexManager;

    protected $document;

    protected $search;

    protected $count;

    public function __construct($indexName, $hosts = [])
    {
        $this->indexName = $indexName;

        if ($hosts)
            $this->client = ClientBuilder::create()->setHosts($hosts)->build();
        else
            $this->client = ClientBuilder::create()->build();
    }


    public function reset($indexName)
    {
        $this->indexName = $indexName;

        $this->search = null;
        $this->document = null;
        $this->indexManager = null;

        return $this;
    }

    public function index()
    {
        if ($this->indexManager == null)
            $this->indexManager = new Index($this->client, $this->indexName);

        return $this->indexManager;
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

