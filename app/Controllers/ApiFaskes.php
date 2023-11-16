<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;

class ApiFaskes extends Controller
{
    public function getHealthFacilityData($jenis)
    {
        $kabupaten = "0130";
        $key = "developerganteng";
        $url = "https://api.teknowebapp.com/indonesian/health/aplicares/search?kabupaten=$kabupaten&key=$key&jenis=$jenis";

        // Gunakan HTTP client CodeIgniter
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url);

        // Cek apakah request berhasil atau tidak
        if ($response->getStatusCode() === 200) {
            // Parsing JSON
            $result = json_decode($response->getBody(), true);

            // Cek apakah parsing JSON berhasil
            if ($result === null) {
                return ['error' => 'Error parsing JSON response'];
            }

            return $result;
        } else {
            // Tangani kesalahan HTTP
            return ['error' => 'HTTP request failed: ' . $response->getStatusCode()];
        }
    }
}
