<?php

namespace App\Controllers;

use App\Models\InvestmentsModel;
use App\Models\SectorsModel;
use App\Models\ViewInvestmentsModel;

class Investments extends BaseController
{
    private $sectors;
    private $investments;
    private $view_investments;

    public function __construct()
    {
        $this->sectors = new SectorsModel();
        $this->investments = new InvestmentsModel();
        $this->view_investments = new ViewInvestmentsModel();
    }

    public function index()
    {
        $latest = $this->view_investments->latest();

        $keyword = $this->request->getVar('s') ?: null;
        $investments = $this->view_investments->retrieve(null, $keyword, 'paginate');
        $pager = $this->view_investments->retrieve(null, $keyword);

        $variable = [
            'page' => 'Promosi Investasi',
            'investments' => $investments,
            'pager' => $pager,
            'keyword' => $keyword,
            'latest' => $latest
        ];

        return $this->view('public/investments/list', $variable);
    }

    public function sector($slug)
    {
        $sector = $this->sectors
            ->where('slug', $slug)
            ->first();

        if ($sector === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $children = $this->sectors
            ->select('id')
            ->where('parent', $sector->id)
            ->findAll();
        $children = array_map(function ($row) {
            return $row->id;
        }, $children);
        $children = [$sector->id, ...$children];

        $keyword = $this->request->getVar('s') ?: null;
        $investments = $this->view_investments->retrieve($children, $keyword, 'paginate');
        $pager = $this->view_investments->retrieve($children, $keyword);

        $variable = [
            'page' => 'Promosi Investasi ' . $sector->name,
            'investments' => $investments,
            'pager' => $pager,
            'keyword' => $keyword,
            'latest' => []
        ];

        return $this->view('public/investments/list', $variable);
    }

    public function subsector($parent, $slug)
    {
        $parent = $this->sectors
            ->where('slug', $parent)
            ->first();
        $sector = $this->sectors
            ->where('slug', $slug)
            ->where('parent', $parent->id)
            ->first();

        if ($sector === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $keyword = $this->request->getVar('s') ?: null;
        $investments = $this->view_investments->retrieve($sector->id, $keyword, 'paginate');
        $pager = $this->view_investments->retrieve($sector->id, $keyword);

        $variable = [
            'page' => 'Promosi Investasi di ' . $sector->name,
            'investments' => $investments,
            'pager' => $pager,
            'keyword' => $keyword,
            'latest' => []
        ];

        return $this->view('public/investments/list', $variable);
    }

    public function read($slug)
    {
        $detail = $this->view_investments
            ->where('slug', $slug)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $previous = $this->view_investments->previous($detail->id);
        $next = $this->view_investments->next($detail->id);

        $variable = [
            'page' => $detail->title,
            'detail' => $detail,
            'previous' => $previous,
            'next' => $next
        ];

        $this->investments->increaseViews($slug);
        return $this->view('public/investments/read', $variable);
    }
}
