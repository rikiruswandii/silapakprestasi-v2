<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    private $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        if ($this->session->get('logged')) {
            return redirect($this->settings->app_prefix . '/overview');
        }

        $variable = [
            'page' => 'Masuk'
        ];

        return $this->view('app/login', $variable);
    }

    public function check()
    {
        $validation = $this->validate([
            'login' => [
                'label' => 'Nama Pengguna',
                'rules' => 'required'
            ],
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'required'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()->withInput()
                ->with('failed', $error);
        }

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        if ($remember) {
             setcookie('login', $login, time() + (10 * 365 * 24 * 60 * 60));
        } else {
            setcookie('login','', time() - 3600);
        }

        $userdata = $this->users
            ->where('login', $login)
            ->first();

        if ($userdata) {
            $verify = password_verify($password, $userdata->password);

            if ($verify) {
                $session = [
                    'logged' => true,
                    'userid' => $userdata->id
                ];

                $this->session->set($session);
                return redirect($this->settings->app_prefix . '/overview');
            }

            return redirect()
                ->back()->withInput()
                ->with('failed', 'Kata sandi tidak benar.');
        }

        return redirect()
            ->back()->withInput()
            ->with('failed', 'Nama pengguna tidak dapat ditemukan.');
    }

    public function kill()
    {
        $this->session->destroy();
        return redirect('auth/login');
    }
}
