<?php

namespace App\Controllers;

use App\Models\KmzModel;
use App\Models\GeojsonModel;

class Maps extends BaseController
{
    private $kmz;
    private $geojson;

    public function __construct()
    {
        $this->kmz = new KmzModel();
        $this->geojson = new GeojsonModel();
    }

    public function index()
    {
        $apiKey = env('API_KEY');
        $apiKey1 = env('API_KEY_1');
        $kmz = $this->kmz->findAll();
        $geojson = $this->geojson->findAll();
        
        $filter = [];
        array_map(function ($row) use (&$filter) {
            $filter[$row->type][] = $row;
        }, $geojson);

        $variable = [
            'page' => 'Peta Potensi & Peluang Investasi',
            'filter' => $filter,
            'geojson' => $geojson,
            'apiKey' => $apiKey,
            'apiKey1' => $apiKey1,
        ];
        return $this->view('public/maps', $variable);
    }
}

