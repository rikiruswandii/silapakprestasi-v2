<?php

namespace App\Controllers;

use App\Models\RegulationsModel;

class Regulations extends BaseController
{
    private $regulations;

    public function __construct()
    {
        $this->regulations = new RegulationsModel();
    }

    public function list($field, $type)
    {
        $investments = $this->regulations
            ->where('field', $field)
            ->where('type', $type)
            ->findAll();
        $regulation = regulations($field);
        $sub = subregulations($type);

        $variable = [
            'page' => implode(' ', ['Regulasi', $sub, $regulation]),
            'field' => $regulation,
            'type' => $sub,
            'regulations' => $investments
        ];

        return $this->view('public/regulations', $variable);
    }
}
