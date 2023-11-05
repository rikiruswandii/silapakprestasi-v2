<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\InvestmentsModel;
use App\Models\SectorsModel;
use App\Models\ViewInvestmentsModel;
use Hermawan\DataTables\DataTable;

class Investments extends BaseController
{
    private $sectors;
    private $investments;
    private $view_investments;

    public function __construct()
    {
        $this->sectors = new SectorsModel();
        $this->investments = new InvestmentsModel();
        $this->view_investments = new ViewInvestmentsModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Investasi',
            'page' => 'Promosi Investasi'
        ];

        return $this->view('app/investments/list', $variable);
    }

    public function datatable()
    {
        $investments = $this->view_investments
            ->select('id, title, slug, sector, views, created_at, updated_at')
            ->builder();

        return DataTable::of($investments)
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
                        $this->settings->app_prefix . '/investments/delete/' . $row->id
                    ),
                ];
                $change = $this->settings->app_prefix . '/investments/edit/' . hashids($row->id);

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor($change, tabler_icon('edit'), $edit);
                $html .= anchor('#', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->edit('title', function ($row) {
                $article = base_url('investment/' . $row->slug);

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

    public function sectors()
    {
        $id = $this->request->getVar('id');
        $sectors = $this->sectors
            ->select('id, name AS text')
            ->where('parent', $id)
            ->findAll();

        return $this->response->setJSON([
            'code' => 200,
            'success' => true,
            // phpcs:ignore
            'message' => 'Paringono siji wektu. Nggo ketemu ro sliramu. Aku pengen ngomong yen aku tresno awakmu. Aku kangen, kangen sliramu.',
            'data' => $sectors
        ]);
    }

    public function add()
    {
        $sectors = $this->sectors
            ->where('parent IS NULL', null, false)
            ->findAll();

        $variable = [
            'parent' => 'Investasi',
            'page' => 'Tambah Promosi Investasi',
            'sectors' => $sectors
        ];

        return $this->view('app/investments/add', $variable);
    }

    public function edit($hashid)
    {
        $id = hashids($hashid, 'decode');
        $detail = $this->view_investments
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $sectors = $this->sectors
            ->where('parent IS NULL', null, false)
            ->findAll();

        $variable = [
            'parent' => 'Investasi',
            'page' => 'Ubah Promosi Investasi',
            'detail' => $detail,
            'sectors' => $sectors
        ];

        return $this->view('app/investments/edit', $variable);
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
            'sector' => [
                'label' => 'Sektor',
                'rules' => 'required|is_not_unique[sectors.id]'
            ],
            'sub' => [
                'label' => 'Sub',
                'rules' => 'permit_empty|is_not_unique[sectors.id]'
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

        $sector = $this->request->getPost('sector');
        $sub = $this->request->getPost('sub');
        $sector = $sub ? $sub : $sector;

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getSize() > 0) {
            $filename = $thumbnail->getRandomName();
            $thumbnail->move('uploads/thumbnails/', $filename);
        }

        $insert = $this->investments->insert([
            'title' => $title,
            'slug' => slugify('investments[slug]', $title),
            'content' => $content,
            'sector' => $sector,
            'thumbnail' => $filename ?: null
        ]);

        if ($insert) {
            return redirect()
                ->to($this->settings->app_prefix . '/investments')
                ->with('success', 'Berhasil menambahkan data Promosi Investasi.');
        }

        return redirect()
            ->back()->withInput()
            ->with('failed', 'Gagal menambahkan data Promosi Investasi.');
    }

    public function update($id)
    {
        $detail = $this->investments
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal mengubah data Promosi Investasi.');
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
            'sector' => [
                'label' => 'Sektor',
                'rules' => 'required|is_not_unique[sectors.id]'
            ],
            'sub' => [
                'label' => 'Sub',
                'rules' => 'permit_empty|is_not_unique[sectors.id]'
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

        $sector = $this->request->getPost('sector');
        $sub = $this->request->getPost('sub');
        $sector = $sub ? $sub : $sector;

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getSize() > 0) {
            $filename = $thumbnail->getRandomName();
            $thumbnail->move('uploads/thumbnails/', $filename);
        }

        $update = $this->investments->update($id, [
            'title' => $title,
            'content' => $content,
            'sector' => $sector,
            'thumbnail' => $filename ?? $detail->thumbnail
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete thumbnail
                @unlink('uploads/thumbnails/' . $detail->thumbnail);
            }

            return redirect()
                ->to($this->settings->app_prefix . '/investments')
                ->with('success', 'Berhasil mengubah data Promosi Investasi.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal mengubah data Promosi Investasi.');
    }

    public function delete($id)
    {
        $detail = $this->investments
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()->back()
                ->with('failed', 'Gagal menghapus data Promosi Investasi.');
        }

        // prevent unique slug
        $hashid = hashids($id);
        $this->investments->update($id, [
            'slug' => $hashid
        ]);

        $delete = $this->investments->delete($id);
        if ($delete) {
            // delete thumbnail
            @unlink('uploads/thumbnails/' . $detail->thumbnail);

            return redirect()->back()
                ->with('success', 'Berhasil menghapus data Promosi Investasi.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal menghapus data Promosi Investasi.');
    }
}
