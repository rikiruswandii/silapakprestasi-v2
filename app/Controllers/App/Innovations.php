<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\InnovationsModel;
use App\Models\ProfilesModel;
use App\Models\ViewInnovationsModel;
use Hermawan\DataTables\DataTable;

class Innovations extends BaseController
{
    private $innovations;
    private $profiles;
    private $view_innovations;

    public function __construct()
    {
        $this->innovations = new InnovationsModel();
        $this->profiles = new ProfilesModel();
        $this->view_innovations = new ViewInnovationsModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Pelayanan',
            'page' => 'Promosi Inovasi'
        ];

        return $this->view('app/innovations/list', $variable);
    }

    public function datatable()
    {
        $innovations = $this->view_innovations
            ->select('id, title, slug, instance, views, created_at, updated_at')
            ->builder();

        return DataTable::of($innovations)
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
                        $this->settings->app_prefix . '/innovations/delete/' . $row->id
                    ),
                ];
                $change = $this->settings->app_prefix . '/innovations/edit/' . hashids($row->id);

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor($change, tabler_icon('edit'), $edit);
                $html .= anchor('#', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->edit('title', function ($row) {
                $article = base_url('innovation/' . $row->slug);

                return anchor($article, $row->title, [
                    'target' => '_blank',
                    'class' => 'text-decoration-none'
                ]);
            })
            ->format('instance', function ($value) {
                return $value ?? 'Belum diset';
            })
            ->format('views', function ($value) {
                return $value . 'x';
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
        $instances = $this->profiles
            ->findAll();

        $variable = [
            'parent' => 'Pelayanan',
            'page' => 'Tambah Promosi Inovasi',
            'instances' => $instances
        ];

        return $this->view('app/innovations/add', $variable);
    }

    public function edit($hashid)
    {
        $id = hashids($hashid, 'decode');
        $detail = $this->innovations
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $instances = $this->profiles
            ->findAll();

        $variable = [
            'parent' => 'Pelayanan',
            'page' => 'Ubah Promosi Inovasi',
            'detail' => $detail,
            'instances' => $instances
        ];

        return $this->view('app/innovations/edit', $variable);
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
                'rules' => 'permit_empty'
            ],
            'pdf' => [
                'label' => 'PDF',
                'rules' => 'ext_in[pdf,pdf]'
            ],
            'instance' => [
                'label' => 'Instansi',
                'rules' => 'required|is_not_unique[profiles.id]'
            ],
            'thumbnail' => [
                'label' => 'Gambar Mini',
                'rules' => 'uploaded[thumbnail]|ext_in[thumbnail,jpg,jpeg,png]|max_size[thumbnail,2048]'
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
        $instance = $this->request->getPost('instance');

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getSize() > 0) {
            $filename = $thumbnail->getRandomName();
            $thumbnail->move('uploads/thumbnails/', $filename);
        }

        $pdf = $this->request->getFile('pdf');
        if ($pdf->getSize() > 0) {
            $pdfname = $pdf->getRandomName();
            $pdf->move('uploads/contents/', $pdfname);
        }

        $insert = $this->innovations->insert([
            'title' => $title,
            'slug' => slugify('innovations[slug]', $title),
            'content' => $content,
            'pdf' => $pdfname ?? null,
            'instance' => $instance,
            'thumbnail' => $filename ?: null
        ]);

        if ($insert) {
            return redirect()
                ->to($this->settings->app_prefix . '/innovations')
                ->with('success', 'Berhasil menambahkan data Promosi Inovasi.');
        }

        return redirect()
            ->back()->withInput()
            ->with('failed', 'Gagal menambahkan data Promosi Inovasi.');
    }

    public function update($id)
    {
        $detail = $this->innovations
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal mengubah data Promosi Inovasi.');
        }

        $validation = $this->validate([
            'title' => [
                'label' => 'Judul',
                'rules' => 'required|max_length[255]'
            ],
            'content' => [
                'label' => 'Konten',
                'rules' => 'permit_empty'
            ],
            'pdf' => [
                'label' => 'PDF',
                'rules' => 'ext_in[pdf,pdf]'
            ],
            'instance' => [
                'label' => 'Instansi',
                'rules' => 'required|is_not_unique[profiles.id]'
            ],
            'thumbnail' => [
                'label' => 'Gambar Mini',
                'rules' => 'ext_in[thumbnail,jpg,jpeg,png]|max_size[thumbnail,2048]'
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
        $instance = $this->request->getPost('instance');

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getSize() > 0) {
            $filename = $thumbnail->getRandomName();
            $thumbnail->move('uploads/thumbnails/', $filename);
        }

        $pdf = $this->request->getFile('pdf');
        if ($pdf->getSize() > 0) {
            $pdfname = $pdf->getRandomName();
            $pdf->move('uploads/contents/', $pdfname);
        }

        $update = $this->innovations->update($id, [
            'title' => $title,
            'content' => $content,
            'pdf' => $pdfname ?? $detail->pdf,
            'instance' => $instance,
            'thumbnail' => $filename ?? $detail->thumbnail
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete thumbnail
                @unlink('uploads/thumbnails/' . $detail->thumbnail);
            }

            if (($pdfname ?? null) !== null) {
                // delete pdf
                @unlink('uploads/contents/' . $detail->pdf);
            }

            return redirect()
                ->to($this->settings->app_prefix . '/innovations')
                ->with('success', 'Berhasil mengubah data Promosi Inovasi.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal mengubah data Promosi Inovasi.');
    }

    public function delete($id)
    {
        $detail = $this->innovations
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal menghapus data Promosi Inovasi.');
        }

        // prevent unique slug
        $hashid = hashids($id);
        $this->innovations->update($id, [
            'slug' => $hashid
        ]);

        $delete = $this->innovations->delete($id);
        if ($delete) {
            // delete thumbnail
            @unlink('uploads/thumbnails/' . $detail->thumbnail);

            // delete contents
            @unlink('uploads/contents/' . $detail->pdf);

            return redirect()->back()
                ->with('success', 'Berhasil menghapus data Promosi Inovasi.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal menghapus data Promosi Inovasi.');
    }
}
