<?php

namespace App\Controllers;

use App\Models\GeojsonModel;

class Maps extends BaseController
{
    private $geojson;
    private $apiFaskes;

    public function __construct()
    {
        $this->geojson = new GeojsonModel();
        $this->apiFaskes = new ApiFaskes();
    }

    public function index()
    {
        $rumahsakitData = $this->apiFaskes->getHealthFacilityData('R');
        $apotekData = $this->apiFaskes->getHealthFacilityData('A');
        $klinikData = $this->apiFaskes->getHealthFacilityData('B');
        $puskesmasData = $this->apiFaskes->getHealthFacilityData('P');
        $apiKey = env('API_KEY');
        $apiKey1 = env('API_KEY_1');
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
            'rumahsakitData' => $rumahsakitData,
            'apotekData' => $apotekData,
            'klinikData' => $klinikData,
            'puskesmasData' => $puskesmasData,
        ];
        return $this->view('public/maps', $variable);
    }
    public function get_data($jenis)
    {
        // Memastikan jenis yang valid (R, A, B, P)
        $validTypes = ['R', 'A', 'B', 'P'];
        if (!in_array($jenis, $validTypes)) {
            return $this->response->setJSON(['error' => 'Invalid type']);
        }
        // Panggil metode yang ada di ApiFaskes
        $data = $this->apiFaskes->getHealthFacilityData($jenis);

        // Atur header respons sebagai JSON
        $this->response->setHeader('Content-Type', 'application/json');

        // Kembalikan data sebagai JSON
        return $this->response->setJSON($data);
    }
}