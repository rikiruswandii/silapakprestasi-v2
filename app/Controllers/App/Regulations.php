<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\RegulationsModel;
use Hermawan\DataTables\DataTable;

class Regulations extends BaseController
{
    private $regulations;

    public function __construct()
    {
        $this->regulations = new RegulationsModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Panel',
            'page' => 'Regulasi',
            'fields' => regulations(),
            'types' => subregulations()
        ];

        return $this->view('app/regulations', $variable);
    }

    public function datatable()
    {
        $regulations = $this->regulations
            ->select('id, name, field, type, file')
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($regulations)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $edit = [
                    'class' => 'text-warning edit-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-form',
                    'data-bs-backdrop' => 'static',
                    'data-id' => $row->id,
                    'data-name' => $row->name,
                    'data-field' => $row->field,
                    'data-type' => $row->type
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
                $html .= anchor('uploads/contents/' . $row->file, tabler_icon('download'), ['target' => '_blank']);
                $html .= anchor('javascript:void(0)', tabler_icon('edit'), $edit);
                $html .= anchor('javascript:void(0)', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->format('field', function ($value) {
                return regulations($value);
            })
            ->format('type', function ($value) {
                return subregulations($value);
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
                'rules' => 'required|min_length[3]|max_length[255]'
            ],
            'field' => [
                'label' => 'Bidang',
                'rules' => 'required|trim|htmlspecialchars'
            ],
            'type' => [
                'label ' => 'Regulasi',
                'rules' => 'required|trim|htmlspecialchars'
            ],
            'file' => [
                'label' => 'Berkas',
                'rules' => 'uploaded[file]|ext_in[file,pdf]'
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
        $field = $this->request->getPost('field');
        $type = $this->request->getPost('type');
        $file = $this->request->getFile('file');
        $filename = $file->getRandomName();
        $file->move('uploads/contents/', $filename);

        $insert = $this->regulations->insert([
            'name' => $name,
            'field' => $field,
            'type' => $type,
            'file' => $filename
        ]);

        if ($insert) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil mengunggah data Regulasi.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengunggah data Regulasi.');
    }

    public function update($id)
    {
        $detail = $this->regulations
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data Regulasi.');
        }

        $validation = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[255]'
            ],
            'field' => [
                'label' => 'Bidang',
                'rules' => 'required|trim|htmlspecialchars'
            ],
            'type' => [
                'label ' => 'Regulasi',
                'rules' => 'required|trim|htmlspecialchars'
            ],
            'file' => [
                'label' => 'Berkas',
                'rules' => 'ext_in[file,pdf]'
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
        $field = $this->request->getPost('field');
        $type = $this->request->getPost('type');

        $file = $this->request->getFile('file');
        if ($file->getSize() > 0) {
            $filename = $file->getRandomName();
            $file->move('uploads/contents/', $filename);
        }

        $update = $this->regulations->update($id, [
            'name' => $name,
            'field' => $field,
            'type' => $type,
            'file' => $filename ?? $detail->file
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete contents
                @unlink('uploads/contents/' . $detail->file);
            }

            return redirect()
                ->back()
                ->with('success', 'Berhasil memperbarui data Regulasi.');
        }
    }

    public function delete($id)
    {
        $detail = $this->regulations
            ->where('id', $id)
            ->first();

        if ($detail == null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data Regulasi.');
        }

        $delete = $this->regulations->delete($id);
        if ($delete) {
            @unlink('uploads/contents/' . $detail->file);

            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data Regulasi.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data Regulasi.');
    }
}
