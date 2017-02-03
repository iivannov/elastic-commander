<?php

namespace Iivannov\ElasticCommander\Criteria;

use Iivannov\ElasticCommander\Contracts\CriteriaInterface;

class RandomCriteria extends Criteria implements CriteriaInterface
{

    protected $size;

    protected $from;

    public function __construct($size = 20, $from = 0)
    {
        $this->size = $size;
        $this->from  = $from;
    }

    public function query()
    {
        $query["function_score"] = [
            "query" => [
                'match_all' => []
            ],
            "functions" => [
                [
                    "random_score" => [
                        "seed" => time()
                    ]
                ]
            ],
            "score_mode" => "sum",
        ];


        return $query;
    }

    public function sort()
    {
        return null;
    }


}