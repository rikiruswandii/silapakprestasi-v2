<?php

namespace App\Controllers;

use App\Models\CategoriesModel;
use App\Models\NewsModel;
use App\Models\ViewCategoriesModel;
use App\Models\ViewNewsModel;

class News extends BaseController
{
    private $categories;
    private $news;
    private $view_news;
    private $view_categories;

    public function __construct()
    {
        $this->categories = new CategoriesModel();
        $this->news = new NewsModel();
        $this->view_news = new ViewNewsModel();
        $this->view_categories = new ViewCategoriesModel();
    }

    public function index()
    {
        $categories = $this->view_categories->findAll();
        $latest = $this->view_news->latest();

        $keyword = $this->request->getVar('s') ?: null;
        $news = $this->view_news->retrieve(null, $keyword, 'paginate');
        $pager = $this->view_news->retrieve(null, $keyword);

        $variable = [
            'page' => 'Berita Terbaru',
            'news' => $news,
            'pager' => $pager,
            'keyword' => $keyword,
            'categories' => $categories,
            'latest' => $latest
        ];

        return $this->view('public/news/list', $variable);
    }

    public function category($slug)
    {
        $category = $this->view_categories
            ->where('slug', $slug)
            ->first();

        if ($category === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $categories = $this->view_categories->findAll();
        $latest = $this->view_news->latest();

        $keyword = $this->request->getVar('s') ?: null;
        $news = $this->view_news->retrieve($slug, $keyword, 'paginate');
        $pager = $this->view_news->retrieve($slug, $keyword);

        $variable = [
            'page' => 'Kategori: ' . $category->name,
            'category' => $category->name,
            'news' => $news,
            'pager' => $pager,
            'keyword' => $keyword,
            'categories' => $categories,
            'latest' => $latest
        ];

        return $this->view('public/news/list', $variable);
    }

    public function read($slug)
    {
        $detail = $this->news
            ->where('slug', $slug)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $categories = $this->view_categories->findAll();
        $latest = $this->view_news->latest();

        $category = $this->categories
            ->where('id', $detail->category)
            ->first();
        $previous = $this->view_news->previous($detail->id);
        $next = $this->view_news->next($detail->id);

        $variable = [
            'page' => $detail->title,
            'detail' => $detail,
            'category' => $category,
            'previous' => $previous,
            'next' => $next,
            'categories' => $categories,
            'latest' => $latest
        ];

        $this->news->increaseViews($slug);
        return $this->view('public/news/read', $variable);
    }
}
