<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\KmzModel;
use Hermawan\DataTables\DataTable;

class Kmz extends BaseController
{
    private $kmz;

    public function __construct()
    {
        $this->kmz = new KmzModel();
    }

    public function index()
    {
        $types = $this->kmz
            ->select('type')
            ->groupBy('type')
            ->orderBy('id')
            ->findAll();

        $variable = [
            'parent' => 'Investasi',
            'page' => 'Peta Potensi',
            'types' => $types
        ];

        return $this->view('app/kmz', $variable);
    }

    public function datatable()
    {
        $kmz = $this->kmz
            ->select('id, name, type, district, file')
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($kmz)
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
                    'data-district' => $row->district,
                ];
                $delete = [
                    'class' => 'text-danger delete-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-danger',
                    'data-bs-backdrop' => 'static',
                    'data-name' => $row->name,
                    'data-url' => base_url(
                        $this->settings->app_prefix . '/kmz/delete/' . $row->id
                    ),
                ];

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor('uploads/kmz/' . $row->file, tabler_icon('download'), ['target' => '_blank']);
                $html .= anchor('javascript:void(0)', tabler_icon('edit'), $edit);
                $html .= anchor('javascript:void(0)', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->format('district', function ($value) {
                return $value ? districts($value) : null;
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
                'rules' => 'required|min_length[3]|max_length[32]'
            ],
            'type' => [
                'label ' => 'Tipe',
                'rules' => 'required'
            ],
            'district' => [
                'label' => 'Kecamatan',
                'rules' => 'required|in_list[' . districts(true) . ']'
            ],
            'file' => [
                'label' => 'Berkas',
                'rules' => 'uploaded[file]|ext_in[file,kmz,kml]'
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
        $district = $this->request->getPost('district');
        $file = $this->request->getFile('file');
        $filename = $file->getRandomName();
        $file->move('uploads/kmz/', $filename);

        $insert = $this->kmz->insert([
            'name' => $name,
            'type' => $type,
            'district' => $district,
            'file' => $filename
        ]);

        if ($insert) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil mengunggah data KMZ.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengunggah data KMZ.');
    }

    public function update($id)
    {
        $detail = $this->kmz
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data KMZ.');
        }

        $validation = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[32]'
            ],
            'type' => [
                'label ' => 'Tipe',
                'rules' => 'required'
            ],
            'district' => [
                'label' => 'Kecamatan',
                'rules' => 'required|in_list[' . districts(true) . ']'
            ],
            'file' => [
                'label' => 'Berkas',
                'rules' => 'ext_in[file,kmz,kml]'
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
        $district = $this->request->getPost('district');

        $file = $this->request->getFile('file');
        if ($file->getSize() > 0) {
            $filename = $file->getRandomName();
            $file->move('uploads/kmz/', $filename);
        }

        $update = $this->kmz->update($id, [
            'name' => $name,
            'type' => $type,
            'district' => $district,
            'file' => $filename ?? $detail->file
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete kmz
                @unlink('uploads/kmz/' . $detail->file);
            }

            return redirect()
                ->back()
                ->with('success', 'Berhasil memperbarui data KMZ.');
        }
    }

    public function delete($id)
    {
        $detail = $this->kmz
            ->where('id', $id)
            ->first();

        if ($detail == null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data KMZ.');
        }

        $delete = $this->kmz->delete($id);
        if ($delete) {
            @unlink('uploads/kmz/' . $detail->file);

            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data KMZ.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data KMZ.');
    }
}
