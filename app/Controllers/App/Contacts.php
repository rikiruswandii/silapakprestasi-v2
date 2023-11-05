<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\ContactsModel;
use Hermawan\DataTables\DataTable;

class Contacts extends BaseController
{
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ContactsModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Subscriptions',
            'page' => 'Pesan Masuk'
        ];

        return $this->view('app/contacts', $variable);
    }

    public function datatable()
    {
        $contacts = $this->contacts
            ->select('id, name, surname, email, phone, message, created_at')
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($contacts)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $edit = [
                    'class' => 'text-primary detail-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-detail',
                    'data-bs-backdrop' => 'static',
                    'data-id' => $row->id,
                    'data-name' => $row->name . ' ' . $row->surname,
                    'data-email' => mailto($row->email),
                    'data-phone' => $row->phone ?: '',
                    'data-message' => $row->message,
                    'href' => 'javascript:void(0)'
                ];

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor('#', tabler_icon('eye'), $edit);
                $html .= '</div>';

                return $html;
            })
            ->edit('name', function ($row) {
                return implode(' ', [$row->name, $row->surname]);
            })
            ->format('created_at', function ($value) {
                return indonesian_date($value);
            })
            ->hide('id')
            ->hide('surname')
            ->hide('email')
            ->hide('phone')
            ->hide('message')
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->toJson(true);
    }
}
