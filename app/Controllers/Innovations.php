<?php

namespace App\Controllers;

use App\Models\InnovationsModel;
use App\Models\ProfilesModel;
use App\Models\ViewInnovationsModel;

class Innovations extends BaseController
{
    private $innovations;
    private $profiles;
    private $view_innovations;

    public function __construct()
    {
        $this->innovations = new InnovationsModel();
        $this->profiles = new ProfilesModel();
        $this->view_innovations = new ViewInnovationsModel();
    }

    public function index()
    {
        $latest = $this->innovations->latest();
        $keyword = $this->request->getVar('s') ?: null;

        if ($keyword) {
            $innovations = $this->view_innovations->retrieve(null, $keyword, 'paginate');
            $pager = $this->view_innovations->retrieve(null, $keyword);

            $innovations = array_map(function ($row) {
                $row->instance = $row->instance ?? 'Promosi Inovasi';
                $row->category = base_url('innovations/' . ($row->code ? hashids($row->code) : ''));

                return $row;
            }, $innovations);

            $variable = [
                'page' => 'Promosi Inovasi',
                'innovations' => $innovations,
                'pager' => $pager,
                'keyword' => $keyword,
                'latest' => $latest
            ];

            return $this->view('public/innovations/list', $variable);
        } else {
            $instances = $this->profiles->paginate(12);
            $pager = $this->profiles->pager;

            $variable = [
                'page' => 'Promosi Inovasi',
                'instances' => $instances,
                'pager' => $pager,
                'keyword' => $keyword,
                'latest' => $latest
            ];

            return $this->view('public/innovations/instances', $variable);
        }
    }

    public function list($code)
    {
        $code = hashids($code, 'decode');
        $latest = $this->innovations->latest();

        $keyword = $this->request->getVar('s') ?: null;
        $innovations = $this->view_innovations->retrieve($code, $keyword, 'paginate');
        $pager = $this->view_innovations->retrieve($code, $keyword);

        $innovations = array_map(function ($row) {
            $row->instance = $row->instance ?? 'Promosi Inovasi';
            $row->category = base_url('innovations/' . ($row->code ? hashids($row->code) : ''));

            return $row;
        }, $innovations);

        $variable = [
            'page' => 'Promosi Inovasi',
            'innovations' => $innovations,
            'pager' => $pager,
            'keyword' => $keyword,
            'latest' => $latest
        ];

        return $this->view('public/innovations/list', $variable);
    }

    public function read($slug)
    {
        $detail = $this->innovations
            ->where('slug', $slug)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $previous = $this->innovations->previous($detail->id);
        $next = $this->innovations->next($detail->id);

        $variable = [
            'page' => $detail->title,
            'detail' => $detail,
            'previous' => $previous,
            'next' => $next
        ];

        $this->innovations->increaseViews($slug);
        return $this->view('public/innovations/read', $variable);
    }
}
