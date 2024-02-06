<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use App\Models\ModelSliders;

class Sliders extends BaseController
{   
    protected $sliders;

    public function __construct()
    {
        $this->sliders = new ModelSliders();
    }
    public function index()
    {
        $variable = [
            'parent' => 'Berita',
            'page' => 'Sliders'
        ];

        return $this->view('app/sliders/slider', $variable);
    }
    public function datatable()
    {
        $slider = $this->sliders
            ->select('id, title, content, images, created_at, updated_at')
            ->builder()
            ->where('deleted_at', null);

        return DataTable::of($slider)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $edit = [
                    'class' => 'text-warning'
                ];
                $delete = [
                    'class' => 'text-danger delete-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-danger',
                    'data-bs-backdrop' => 'static',
                    'data-name' => $row->title,
                    'data-url' => base_url(
                        $this->settings->app_prefix . '/sliders/delete/' . $row->id
                    ),
                ];
                $change = $this->settings->app_prefix . '/sliders/edit/' . hashids($row->id);

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor($change, tabler_icon('edit'), $edit);
                $html .= anchor('#', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
        
            ->format('created_at', function ($value) {
                return indonesian_date($value);
            })
            ->edit('updated_at', function ($row) {
                return indonesian_date($row->updated_at ?? $row->created_at);
            })
            ->hide('id')
            ->hide('slug')
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->toJson(true);
    }

    public function add()
    {

        $variable = [
            'parent' => 'Berita',
            'page' => 'Tambah Sliders'
        ];

        return $this->view('app/sliders/add', $variable);
    }

    public function edit($hashid)
    {
        $id = hashids($hashid, 'decode');
        $detail = $this->sliders
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        $variable = [
            'parent' => 'Berita',
            'page' => 'Ubah Slider',
            'detail' => $detail
        ];

        return $this->view('app/sliders/edit', $variable);
    }

    public function insert()
    {
        $validation = $this->validate([
            'title' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[255]'
            ],
            'content' => [
                'label' => 'Konten',
                'rules' => 'required'
            ],
            'images' => [
                'label' => 'Gambar',
                'rules' => 'ext_in[images,jpg,jpeg,png]|max_size[images,2048]'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()->withInput()
                ->with('failed', $error);
        }

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        $images = $this->request->getFile('images');
        if ($images->getSize() > 0) {
            $filename = $images->getRandomName();
            $images->move('uploads/thumbnails/', $filename);
        }

        $insert = $this->sliders->insert([
            'title' => $title,
            'content' => $content,
            'images' => $filename ?? null
        ], true);

        if ($insert) {
            return redirect()
                ->to($this->settings->app_prefix . '/sliders')
                ->with('success', 'Berhasil menambahkan data Sliders.');
        }

        return redirect()
            ->back()->withInput()
            ->with('failed', 'Gagal menambahkan data Sliders.');
    }

    public function update($id)
    {
        $detail = $this->sliders
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data Sliders.');
        }

        $validation = $this->validate([
            'title' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[255]'
            ],
            'content' => [
                'label' => 'Konten',
                'rules' => 'required'
            ],
            'images' => [
                'label' => 'Gambar',
                'rules' => 'ext_in[images,jpg,jpeg,png]|max_size[images,2048]'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');

        $images = $this->request->getFile('images');
        if ($images->getSize() > 0) {
            $filename = $images->getRandomName();
            $images->move('uploads/thumbnails/', $filename);
        }

        $update = $this->sliders->update($id, [
            'title' => $title,
            'content' => $content,
            'images' => $filename ?? $detail->images
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete thumbnail
                @unlink('uploads/thumbnails/' . $detail->images);
            }

            return redirect()
                ->to($this->settings->app_prefix . '/sliders')
                ->with('success', 'Berhasil mengubah data Sliders.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengubah data Sliders.');
    }

    public function delete($id)
    {
        $detail = $this->sliders
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data Slider.');
        }

        $delete = $this->sliders->delete($id);
        if ($delete) {
            // delete thumbnail
            @unlink('uploads/thumbnails/' . $detail->thumbnail);

            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data Slider.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data Slider.');
    }
}
