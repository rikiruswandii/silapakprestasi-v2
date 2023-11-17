<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ApiHotel extends BaseController
{
    public function getHotelData()
    {
        $key = "developerganteng";
        $url = "https://api.teknowebapp.com/indonesian/tourism/sipinterberisi/hotel?key=$key";

        // Gunakan HTTP client CodeIgniter
        $client = \Config\Services::curlrequest();
        $response = $client->get($url);

        // Cek apakah request berhasil atau tidak
        if ($response->getStatusCode() === 200) {
            // Parsing JSON
            $result = json_decode($response->getBody(), true);

            // Cek apakah parsing JSON berhasil
            if ($result === null) {
                // Tambahkan informasi kesalahan parsing JSON
                return ['error' => 'Error parsing JSON response', 'response' => $response->getBody()];
            }

            return $result;
        } else {
            // Tangani kesalahan HTTP dengan memberikan pesan error
            return ['error' => 'HTTP request failed: ' . $response->getStatusCode()];
        }
    }
}
