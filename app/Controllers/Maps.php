<?php

namespace App\Controllers;

use App\Models\KmzModel;
use App\Models\GeojsonModel;
use App\Models\SearchMap;

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
    public function search()
    {
        $keyword = $this->request->getGet('keyword');

        if (!empty($keyword)) {
            $locationModel = new SearchMap();
            $results = $locationModel->search($keyword);

            return $this->response->setJSON(['results' => $results]);
        } else {
            // Handle jika 'keyword' tidak ada dalam URL
            return $this->response->setJSON(['results' => []]);
        }
    }

    
}

