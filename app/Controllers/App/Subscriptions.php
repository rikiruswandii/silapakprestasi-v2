<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\SubscriptionsModel;
use Hermawan\DataTables\DataTable;

class Subscriptions extends BaseController
{
    private $subsriptions;

    public function __construct()
    {
        $this->subsriptions = new SubscriptionsModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Subscriptions',
            'page' => 'Daftar Subscriptions'
        ];

        return $this->view('app/subscriptions', $variable);
    }

    public function datatable()
    {
        $subsriptions = $this->subsriptions
            ->select('id, email, created_at')
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($subsriptions)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $delete = [
                    'class' => 'text-danger delete-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-danger',
                    'data-bs-backdrop' => 'static',
                    'data-name' => $row->email,
                    'data-url' => base_url(
                        $this->settings->app_prefix . '/subscriptions/delete/' . $row->id
                    ),
                ];

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor('#', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->format('email', function ($value) {
                return mailto($value, $value, [
                    'class' => 'text-decoration-none'
                ]);
            })
            ->format('created_at', function ($value) {
                return indonesian_date($value);
            })
            ->hide('id')
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->toJson(true);
    }

    public function delete($id)
    {
        $detail = $this->subsriptions
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal menghapus data Pelanggan.');
        }

        $delete = $this->subsriptions->delete($id);
        if ($delete) {
            return redirect()->back()
                ->with('success', 'Berhasil menghapus data Pelanggan.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal menghapus data Pelanggan.');
    }
}
