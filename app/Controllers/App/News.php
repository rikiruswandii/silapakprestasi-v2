<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use App\Models\NewsModel;
use App\Models\ViewNewsModel;
use Hermawan\DataTables\DataTable;

class News extends BaseController
{
    private $news;
    private $categories;
    private $view_news;

    public function __construct()
    {
        $this->news = new NewsModel();
        $this->categories = new CategoriesModel();
        $this->view_news = new ViewNewsModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Berita',
            'page' => 'Artikel'
        ];

        return $this->view('app/news/article', $variable);
    }

    public function datatable()
    {
        $news = $this->view_news
            ->builder();

        return DataTable::of($news)
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
                        $this->settings->app_prefix . '/news/delete/' . $row->id
                    ),
                ];
                $change = $this->settings->app_prefix . '/news/edit/' . hashids($row->id);

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor($change, tabler_icon('edit'), $edit);
                $html .= anchor('#', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->edit('title', function ($row) {
                $article = base_url('news/' . $row->slug);

                return anchor($article, $row->title, [
                    'target' => '_blank',
                    'class' => 'text-decoration-none'
                ]);
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
        $categories = $this->categories
            ->orderBy('id', 'DESC')
            ->findAll();

        $variable = [
            'parent' => 'Berita',
            'page' => 'Tambah Artikel',
            'categories' => $categories
        ];

        return $this->view('app/news/add', $variable);
    }

    public function edit($hashid)
    {
        $id = hashids($hashid, 'decode');
        $detail = $this->news
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $categories = $this->categories
            ->orderBy('id', 'DESC')
            ->findAll();

        $variable = [
            'parent' => 'Berita',
            'page' => 'Ubah Artikel',
            'detail' => $detail,
            'categories' => $categories
        ];

        return $this->view('app/news/edit', $variable);
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
            'category' => [
                'label' => 'Kategori',
                'rules' => 'required|is_not_unique[categories.id]'
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
        $category = $this->request->getPost('category');

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getSize() > 0) {
            $filename = $thumbnail->getRandomName();
            $thumbnail->move('uploads/thumbnails/', $filename);
        }

        $insert = $this->news->insert([
            'title' => $title,
            'slug' => slugify('news[slug]', $title),
            'content' => $content,
            'thumbnail' => $filename ?? null,
            'category' => $category
        ], true);

        if ($insert) {
            return redirect()
                ->to($this->settings->app_prefix . '/news')
                ->with('success', 'Berhasil menambahkan data Artikel.');
        }

        return redirect()
            ->back()->withInput()
            ->with('failed', 'Gagal menambahkan data Artikel.');
    }

    public function update($id)
    {
        $detail = $this->news
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data Artikel.');
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
            'category' => [
                'label' => 'Kategori',
                'rules' => 'required|is_not_unique[categories.id]'
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
                ->back()
                ->with('failed', $error);
        }

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');
        $category = $this->request->getPost('category');

        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail->getSize() > 0) {
            $filename = $thumbnail->getRandomName();
            $thumbnail->move('uploads/thumbnails/', $filename);
        }

        $update = $this->news->update($id, [
            'title' => $title,
            'content' => $content,
            'thumbnail' => $filename ?? $detail->thumbnail,
            'category' => $category
        ]);

        if ($update) {
            if (($filename ?? null) !== null) {
                // delete thumbnail
                @unlink('uploads/thumbnails/' . $detail->thumbnail);
            }

            return redirect()
                ->to($this->settings->app_prefix . '/news')
                ->with('success', 'Berhasil mengubah data Artikel.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengubah data Artikel.');
    }

    public function delete($id)
    {
        $detail = $this->news
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data Artikel.');
        }

        // prevent unique slug
        $hashid = hashids($id);
        $this->news->update($id, [
            'slug' => $hashid
        ]);

        $delete = $this->news->delete($id);
        if ($delete) {
            // delete thumbnail
            @unlink('uploads/thumbnails/' . $detail->thumbnail);

            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data Artikel.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data Artikel.');
    }
}
