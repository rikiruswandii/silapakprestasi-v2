<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\GeojsonModel;
use Hermawan\DataTables\DataTable;

class Geojson extends BaseController
{
    private $geojson;

    public function __construct()
    {
        $this->geojson = new GeojsonModel();
    }

    public function index()
    {
        $types = $this->geojson
            ->select('type')
            ->groupBy('type')
            ->orderBy('id')
            ->findAll();

        $variable = [
            'parent' => 'Investasi',
            'page' => 'Peta Potensi',
            'types' => $types
        ];

        return $this->view('app/geojson', $variable);
    }

    public function datatable()
    {
        $geojson = $this->geojson
            ->select('id, name, type, file')
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($geojson)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $edit = [
                    'class' => 'text-warning edit-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-form',
                    'data-bs-backdrop' => 'static',
                    'data-id' => $row->id,
                    'data-name' => $row->name,
                    'data-type' => $row->type,
                ];
                $delete = [
                    'class' => 'text-danger delete-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-danger',
                    'data-bs-backdrop' => 'static',
                    'data-name' => $row->name,
                    'data-url' => base_url(
                        $this->settings->app_prefix . '/geojson/delete/' . $row->id
                    ),
                ];

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor('uploads/geojson/' . $row->file, tabler_icon('download'), ['target' => '_blank']);
                $html .= anchor('javascript:void(0)', tabler_icon('edit'), $edit);
                $html .= anchor('javascript:void(0)', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->hide('id')
            ->hide('file')
            ->toJson(true);
    }

    public function upload()
    {
        $validation = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[52]'
            ],
            'type' => [
                'label ' => 'Tipe',
                'rules' => 'required'
            ],
            'file' => [
                'label' => 'Berkas',
                'rules' => 'uploaded[file]|mime_in[file,application/json,geojson]',
            ]

        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');
        $file = $this->request->getFile('file');
        $filename = $file->getRandomName();
        $file->move('uploads/geojson/', $filename);

        $insert = $this->geojson->insert([
            'name' => $name,
            'type' => $type,
            'file' => $filename
        ]);

        if ($insert) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil mengunggah data Geojson.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengunggah data Geojson.');
    }

    public function update($id)
    {
        $detail = $this->geojson
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data Geojson.');
        }

        $validation = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[52]'
            ],
            'type' => [
                'label ' => 'Tipe',
                'rules' => 'required'
            ],
            'file' => [
                'label' => 'Berkas',
                'rules' => 'mime_in[file,application/json]'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $name = $this->request->getPost('name');
        $type = $this->request->getPost('type');

        $file = $this->request->getFile('file');
        if ($file->getSize() > 0) {
            $filename = $file->getRandomName();
            $file->move('uploads/geojson/', $filename);
        }

        $update = $this->geojson->update($id, [
            'name' => $name,
            'type' => $type,
            'file' => $filename ?? $detail->file
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete geojson
                @unlink('uploads/geojson/' . $detail->file);
            }

            return redirect()
                ->back()
                ->with('success', 'Berhasil memperbarui data Geojson.');
        }
    }

    public function delete($id)
    {
        $detail = $this->geojson
            ->where('id', $id)
            ->first();

        if ($detail == null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data Geojson.');
        }

        $delete = $this->geojson->delete($id);
        if ($delete) {
            @unlink('uploads/geojson/' . $detail->file);

            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data Geojson.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data Geojson.');
    }
}
