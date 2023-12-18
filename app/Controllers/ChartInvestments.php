<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SectorsModel;
use App\Models\ViewInvestmentsModel;
use App\Models\ViewInnovationsModel;
use App\Models\ProfilesModel;

class ChartInvestments extends BaseController
{
    private $sectors;
    private $view_investments;
    private $view_innovations;
    private $profiles;

    public function __construct()
    {
        $this->sectors = new SectorsModel();
        $this->view_investments = new ViewInvestmentsModel();
        $this->view_innovations = new ViewInnovationsModel();
        $this->profiles = new ProfilesModel();
    }

    public function index()
    {
        $sectors = $this->sectors->findAll();
        $investments = $this->view_investments->findAll();
        $innovations = $this->view_innovations->findAll();
        $profiles = $this->profiles->findAll();
        $innovationsCount = count($innovations);
        $investmentsCount = count($investments);
        $invest = 'Promosi Investasi';
        $innov = 'Promosi Innovasi';

        $chartData = [];
        $chartInnov = [];
        foreach ($sectors as $sector) {
            $sectorsCount = $this->countSectors([$sector->id]);
            $chartData[] = [
                'sector' => $sector->name,
                'sectorsCount' => $sectorsCount['val'],
                'sectorsIdCount' => $sectorsCount['valId']
            ];
        }
        foreach ($profiles as $instansi) {
            $opd = $this->countInstance([$instansi->id]);
            $chartInnov[] = [
                'opdCount' => $opd['val'],
                'opdIdCount' => $opd['valId'],
                'instansi' => $instansi->title,
            ];
        }

        return $this->response->setJSON([
            'chartData' => $chartData,
            'chartInnov' => $chartInnov,
            'investmentsCount' => $investmentsCount,
            'invest' => $invest,
            'innov' => $innov,
            'innovationsCount' => $innovationsCount
        ]);
    }

    public function countSectors($sectors)
    {
        $val = $this->view_investments->whereIn('idsector', $sectors)->countAllResults();
        $valId = $this->view_investments->whereIn('idsector', $sectors)->findAll();

        $bakmandi = [
            'val' => $val,
            'valId' => $valId
        ];
        return $bakmandi;
    }

    public function countInstance($instance) {
        $val = $this->view_innovations->whereIn('code', $instance)->countAllResults();
        $valId = $this->view_innovations->whereIn('code', $instance)->findAll();

        $ayam = [
            'val' => $val,
            'valId' => $valId
        ];
        return $ayam;
    }

}
