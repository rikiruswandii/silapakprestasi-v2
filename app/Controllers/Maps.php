<?php

namespace App\Controllers;

use App\Models\GeojsonModel;

class Maps extends BaseController
{
    private $geojson;
    private $apiWisata;
    private $apiHotel;

    public function __construct()
    {
        $this->geojson = new GeojsonModel();
        $this->api = new Api();
    }

    public function index()
    {
        $rumahsakitData = $this->api->getHealthFacilityData('R');
        $apotekData = $this->api->getHealthFacilityData('A');
        $apotekUtama = $this->api->getHealthFacilityData('S');
        $klinikData = $this->api->getHealthFacilityData('B');
        $puskesmasData = $this->api->getHealthFacilityData('P');
        $wisataData = $this->api->getTouristData();
        $hotelData = $this->api->getHotelData();
        $apiKey = env('API_KEY');
        $apiKey1 = env('API_KEY_1');
        $geojson = $this->geojson->findAll();
            $gaboleh5 = 'A';
            $gaboleh1 = 'B';
            $gaboleh2 = 'R';        
            $gaboleh3 = 'S';        
            $gaboleh4 = 'P';
            $gaboleh6 = 'maps/get_wisata';
            $gaboleh7 = 'maps/get_hotel';

        $filter = [];
        $fasum = [];

        foreach ($geojson as $row) {
            if ($row->type !== 'Fasilitas Umum') {
                $filter[$row->type][] = $row;
            } else {
                $fasum[] = $row;
            }
        }


        $variable = [
            'page' => 'Peta Potensi & Peluang Investasi',
            'filter' => $filter,
            'fasum' => $fasum,
            'geojson' => $geojson,
            'apiKey' => $apiKey,
            'apiKey1' => $apiKey1,
            'rumahsakitData' => $rumahsakitData,
            'apotekData' => $apotekData,
            'apotekUtama' => $apotekUtama,
            'klinikData' => $klinikData,
            'puskesmasData' => $puskesmasData,
            'wisataData' => $wisataData,
            'hotelData' => $hotelData,
            'gaboleh1' => $gaboleh1,
            'gaboleh2' => $gaboleh2,
            'gaboleh3' => $gaboleh3,
            'gaboleh4' => $gaboleh4,
            'gaboleh5' => $gaboleh5,
            'gaboleh6' => $gaboleh6,
            'gaboleh7' => $gaboleh7,
        ];
        return $this->view('public/maps', $variable);
    }

    public function get_data($jenis)
    {
        $validTypes = ['R', 'A', 'S', 'B', 'P'];
        if (!in_array($jenis, $validTypes)) {
            return $this->response->setJSON(['error' => 'Invalid type']);
        }
        $data = $this->api->getHealthFacilityData($jenis);

        // Atur header respons sebagai JSON
        $this->response->setHeader('Content-Type', 'application/json');

        // Kembalikan data sebagai JSON
        return $this->response->setJSON($data);
    }
    public function get_wisata()
    {
        try {
            $data = $this->api->getTouristData();
            $this->response->setHeader('Content-Type', 'application/json');
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }
    public function get_hotel()
    {
        try {
            $data = $this->api->getHotelData();
            $this->response->setHeader('Content-Type', 'application/json');
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }
}
