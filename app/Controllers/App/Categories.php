<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use Hermawan\DataTables\DataTable;

class Categories extends BaseController
{
    private $categories;

    public function __construct()
    {
        $this->categories = new CategoriesModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Berita',
            'page' => 'Kategori'
        ];

        return $this->view('app/news/categories', $variable);
    }

    public function datatable()
    {
        $categories = $this->categories
            ->select('id, name')
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($categories)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $edit = [
                    'class' => 'text-warning edit-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-form',
                    'data-bs-backdrop' => 'static',
                    'data-id' => $row->id,
                    'data-name' => $row->name
                ];
                $delete = [
                    'class' => 'text-danger delete-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-danger',
                    'data-bs-backdrop' => 'static',
                    'data-name' => $row->name,
                    'data-url' => base_url(
                        $this->settings->app_prefix . '/categories/delete/' . $row->id
                    ),
                ];

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor('javascript:void(0)', tabler_icon('edit'), $edit);
                $html .= anchor('javascript:void(0)', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->hide('id')
            ->toJson(true);
    }

    public function insert()
    {
        $validation = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[64]'
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
        $insert = $this->categories->insert([
            'name' => $name,
            'slug' => slugify('categories[slug]', $name)
        ], true);

        if ($insert) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil menambahkan data Kategori.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menambahkan data Kategori.');
    }

    public function update($id)
    {
        $detail = $this->categories
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data Kategori.');
        }

        $validation = $this->validate([
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|max_length[64]'
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
        $update = $this->categories->update($id, [
            'name' => $name
        ]);

        if ($update) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil mengubah data Kategori.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengubah data Kategori.');
    }

    public function delete($id)
    {
        $detail = $this->categories
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data Kategori.');
        }

        if ($id == '1') {
            return redirect()
                ->back()
                ->with('failed', 'Kategori ini tidak dapat dihapus.');
        }

        // prevent unique field
        $hashid = hashids($id);
        $this->categories->update($id, [
            'slug' => $hashid
        ]);

        $delete = $this->categories->delete($id);
        if ($delete) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data Kategori.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data Kategori.');
    }
}
