<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $variable = [
            'page' => ''
        ];

        return $this->view('public/landing', $variable);
    }

    public function contact()
    {
        $variable = [
            'page' => 'Hubungi Kami'
        ];

        return $this->view('public/contact', $variable);
    }

    public function about()
    {
        $variable = [
            'page' => 'Tentang',
            'content' => $this->settings->app_about
        ];

        return $this->view('public/about', $variable);
    }

    public function override()
    {
        $variable = [
            'page' => 'Halaman Tidak Ditemukan'
        ];

        echo $this->view('public/override', $variable);
    }
}
