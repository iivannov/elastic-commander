<?php

namespace Iivannov\ElasticCommander\Criteria;


use Iivannov\ElasticCommander\Contracts\CriteriaInterface;

class GeoDistanceCriteria extends Criteria implements CriteriaInterface
{

    protected $lat;

    protected $lng;

    public function __construct($lat, $lng, $radius, $size = null, $from = null)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->radius = $radius;

        if($size) {
            $this->size = $size;
        }

        if($from) {
            $this->from = $from;
        }
    }


    public function query()
    {
        $query['filtered']['filter']['bool']['must'][] = [
            'geo_distance' => [
                'distance' => $this->radius . 'm',
                'location' => [
                    'lat' => $this->lat,
                    'lon' => $this->lng
                ]
            ]
        ];

        return $query;
    }

    public function sort()
    {
        return [
            '_geo_distance' => [
                'order' => 'asc',
                'unit' => 'm',
                'location' => [
                    'lat' => $this->lat,
                    'lon' => $this->lng
                ],
                'distance_type' => 'plane'
            ]
        ];
    }



}