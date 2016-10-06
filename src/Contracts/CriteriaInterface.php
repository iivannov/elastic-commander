<?php

namespace Iivannov\ElasticCommander\Contracts;


interface CriteriaInterface
{

    public function query();

    public function sort();

    public function size();

    public function from();
}