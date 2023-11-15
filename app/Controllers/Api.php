<?php

namespace App\Controllers;

use App\Models\KmzModel;
use App\Models\ContactsModel;
use App\Models\SubscriptionsModel;

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
    public function districts()
    {
        try {
            // Jika ini adalah permintaan AJAX
            if ($this->request->isAJAX()) {
                $id = $this->request->getVar('id');
            }

            $client = \Config\Services::curlrequest();

            $districts = $client->get('https://api.teknowebapp.com/indonesian/health/aplicares/search?kabupaten=0130&key=developerganteng&jenis=R');

            $response = json_decode($districts->getBody())->data;

            // Jika ini adalah permintaan AJAX, kembalikan respons JSON
            if ($this->request->isAJAX()) {
                return $this->response->setJSON($response);
            }

            // Jika ini adalah permintaan HTTP biasa, tampilkan view atau respons lainnya
            return view('public/maps', ['data' => $response]);
        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons kesalahan jika perlu
            log_message('error', 'Error fetching data from API: ' . $e->getMessage());

            // Jika ini adalah permintaan AJAX, kembalikan respons JSON
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['error' => 'Failed to fetch data.']);
            }

            // Jika ini adalah permintaan HTTP biasa, tampilkan pesan kesalahan
            return 'Failed to fetch data.';
        }
    }

}
