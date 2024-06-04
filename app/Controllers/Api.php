<?php

namespace App\Controllers;

use App\Models\KmzModel;
use App\Models\ContactsModel;
use App\Models\SubscriptionsModel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;

class Api extends BaseController
{
    private $contacts;
    private $subscriptions;
    private $kmz;

    public function __construct()
    {
        $this->contacts = new ContactsModel();
        $this->subscriptions = new SubscriptionsModel();
        $this->kmz = new KmzModel();
    }

    private function __response(int $code, bool $status, string $message = '', array $data = null)
    {
        $response = [
            'code' => $code,
            'success' => $status,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        $this->response->setStatusCode($code);
        return $this->response->setJSON($response);
    }

    public function index()
    {
        $description = 'This restful API is used for consumption of the ' . $this->settings->app_name . ' website.';
        return $this->__response(200, true, $description);
    }

    public function contact()
    {
        $validation = $this->validate([
            'name' => [
                'label' => 'Nama Depan',
                'rules' => 'required|max_length[64]|alpha'
            ],
            'surname' => [
                'label' => 'Nama Belakang',
                'rules' => 'required|max_length[64]|alpha'
            ],
            'email' => [
                'label' => 'Surel',
                'rules' => 'required|valid_email'
            ],
            'message' => [
                'label' => 'Pesan',
                'rules' => 'required|min_length[18]'
            ]
        ]);

        $insert = false;
        $error = 'Terjadi kesalahan, silahkan coba beberapa saat lagi.';

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);
        } else {
            $name = $this->request->getPost('name');
            $surname = $this->request->getPost('surname');
            $email = $this->request->getPost('email');
            $phone = $this->request->getPost('phone');
            $message = $this->request->getPost('message');

            $insert = $this->contacts->insert([
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'phone' => $phone,
                'message' => $message
            ]);
        }

        if ($insert) {
            $data = [
                'type' => 'success',
                'message' => 'Terima kasih telah mengirimkan pesan, kami akan segera menghubungi Anda kembali.'
            ];
        } else {
            $data = [
                'type' => 'danger',
                'message' => $error
            ];
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        echo $error;
    }

    public function subscribe()
    {
        $validation = $this->validate([
            'email' => [
                'label' => 'Alamat Surel',
                'rules' => 'required|valid_email'
            ]
        ]);

        $insert = false;
        $error = 'Terjadi kesalahan, silahkan coba beberapa saat lagi.';

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);
        } else {
            $email = $this->request->getPost('email');
            $insert = $this->subscriptions->insert([
                'email' => $email
            ]);
        }

        if ($insert) {
            $data = [
                'type' => 'success',
                'message' => 'Terima kasih, kami akan mengirimkan informasi kepada Anda saat ada informasi terkini.'
            ];
        } else {
            $data = [
                'type' => 'error',
                'message' => $error
            ];
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        echo $error;
    }

    public function kmz()
    {
        $token = $this->request->getVar('apikey');

        if (!in_array($token, [$this->settings->app_apikey, $this->session->get('apikey')])) {
            return $this->__response(403, false, 'Sampeyan mboten saget ngakses endpoint iki.');
        }

        $district = $this->request->getVar('district');
        if ($token === $this->session->get('apikey') && !$district) {
            return $this->__response(403, false, 'Mboten saget, mboten wonten query district.');
        }

        $kmz = $this->kmz;
        if (!!$district) {
            $kmz->where('district', $district);
        }

        $data = [];
        foreach ($kmz->findAll() as $row) {
            $data[$row->type][] = [
                'id' => hashids($row->id, 'encode'),
                'name' => $row->name,
                'district' => $row->district ? districts($row->district) : null,
                'filename' => $row->file,
                'download' => base_url('uploads/kmz/' . $row->file),
                'created' => $row->created_at,
                'updated' => $row->updated_at
            ];
        }

        return $this->__response(200, true, 'Monggo dipake sesuai kebutuhan mawon!', $data);
    }

     public function getHealthFacilityData($jenis)
    {
        try {
            $kabupaten = "0130";
            $key = env('KEY');
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
        } catch (\Exception $e) {
            // Tangani exception jika terjadi kesalahan saat melakukan permintaan
            return ['error' => 'An error occurred while processing the request'];
        }
    }

    public function getHotelData()
    {
        try {
            $key = env('KEY');
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
        } catch (\Exception $e) {
            // Tangani exception jika terjadi kesalahan saat melakukan permintaan
            return ['error' => 'An error occurred while processing the request'];
        }
    }

    public function getTouristData()
    {
        try {
            $key = env('KEY');
            $url = "https://api.teknowebapp.com/indonesian/tourism/sipinterberisi/wisata?key=$key";

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
        } catch (\Exception $e) {
            // Tangani exception jika terjadi kesalahan saat melakukan permintaan
            return ['error' => 'An error occurred while processing the request'];
        }
    }
}
