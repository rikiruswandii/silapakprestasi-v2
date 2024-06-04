<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\ProfilesModel;
use Hermawan\DataTables\DataTable;

class Profiles extends BaseController
{
    private $profiles;

    public function __construct()
    {
        $this->profiles = new ProfilesModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Pelayanan',
            'page' => 'Profil Layanan Instansi'
        ];

        return $this->view('app/profiles/list', $variable);
    }

    public function datatable()
    {
        $profiles = $this->profiles
            ->builder()
            ->where('deleted_at IS NULL', null, false);

        return DataTable::of($profiles)
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
                        $this->settings->app_prefix . '/profiles/delete/' . $row->id
                    ),
                ];
                $change = $this->settings->app_prefix . '/profiles/edit/' . hashids($row->id);

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor($change, tabler_icon('edit'), $edit);
                $html .= anchor('#', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->edit('title', function ($row) {
                $article = base_url('profile/' . $row->slug);

                return anchor($article, $row->title, [
                    'target' => '_blank',
                    'class' => 'text-decoration-none'
                ]);
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
        $variable = [
            'parent' => 'Pelayanan',
            'page' => 'Tambah Profil Layanan Instansi'
        ];

        return $this->view('app/profiles/add', $variable);
    }

    public function edit($hashid)
    {
        $id = hashids($hashid, 'decode');
        $detail = $this->profiles
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $variable = [
            'parent' => 'Pelayanan',
            'page' => 'Ubah Profil Layanan Instansi',
            'detail' => $detail
        ];

        return $this->view('app/profiles/edit', $variable);
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

        $insert = $this->profiles->insert([
            'title' => $title,
            'slug' => slugify('profiles[slug]', $title),
            'content' => $content,
            'pdf' => $pdfname ?? null,
            'thumbnail' => $filename ?: null
        ]);

        if ($insert) {
            return redirect()
                ->to($this->settings->app_prefix . '/profiles')
                ->with('success', 'Berhasil menambahkan data Promosi Layanan Instansi.');
        }

        return redirect()
            ->back()->withInput()
            ->with('failed', 'Gagal menambahkan data Promosi Layanan Instansi.');
    }

    public function update($id)
    {
        $detail = $this->profiles
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal mengubah data Promosi Layanan Instansi.');
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

        $update = $this->profiles->update($id, [
            'title' => $title,
            'content' => $content,
            'pdf' => $pdfname ?? $detail->pdf,
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
                ->to($this->settings->app_prefix . '/profiles')
                ->with('success', 'Berhasil mengubah data Promosi Layanan Instansi.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal mengubah data Promosi Layanan Instansi.');
    }

    public function delete($id)
    {
        $detail = $this->profiles
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal menghapus data Promosi Layanan Instansi.');
        }

        // prevent unique slug
        $hashid = hashids($id);
        $this->profiles->update($id, [
            'slug' => $hashid
        ]);

        $delete = $this->profiles->delete($id);
        if ($delete) {
            // delete thumbnail
            @unlink('uploads/thumbnails/' . $detail->thumbnail);

            // delete contents
            @unlink('uploads/contents/' . $detail->pdf);

            return redirect()->back()
                ->with('success', 'Berhasil menghapus data Promosi Layanan Instansi.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal menghapus data Promosi Layanan Instansi.');
    }
}
