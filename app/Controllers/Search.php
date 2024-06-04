<?php

namespace App\Controllers;

use App\Models\ViewProductsModel;

class Search extends BaseController
{
    private $view_products;

    public function __construct()
    {
        $this->view_products = new ViewProductsModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('s') ?: null;
        if ($keyword === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $products = $this->view_products
            ->like('title', $keyword, 'both')
            ->orderBy('id', 'DESC')
            ->paginate(6);
        $pager = $this->view_products
            ->like('title', $keyword, 'both')
            ->orderBy('id', 'DESC')
            ->pager;
        
        $variable = [
            'page' => 'Hasil pencarian: "' . strip_tags($keyword) . '"',
            'products' => $products,
            'pager' => $pager,
            'keyword' => $keyword
        ];

        return $this->view('public/search', $variable);
    }
}
