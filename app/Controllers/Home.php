<?php

namespace App\Controllers;

use App\Models\ViewInvestmentsModel;
use App\Models\ViewInnovationsModel;

class Home extends BaseController
{
    private $view_investments;
    private $view_innovations;

    public function __construct()
    {
        $this->view_investments = new ViewInvestmentsModel();
        $this->view_innovations = new ViewInnovationsModel();
    }

    public function index()
    {
        $investments = $this->view_investments->paginate(4);
        $innovations = $this->view_innovations->paginate(4);
        $innovations = array_map(function ($row) {
            $row->instance = $row->instance ?? 'Promosi Inovasi';
            $row->category = base_url('innovations/' . ($row->code ? hashids($row->code) : ''));

            return $row;
        }, $innovations);
        $variable = [
            'page' => '',
            'investments' => $investments,
            'innovations' => $innovations
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
