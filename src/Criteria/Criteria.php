<?php

namespace Iivannov\ElasticCommander\Criteria;


abstract class Criteria
{

    protected $size = 20;

    protected $from = 0;

    public function size()
    {
        return $this->size;
    }

    public function from()
    {
        return $this->from;
    }



}