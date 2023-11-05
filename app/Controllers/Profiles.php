<?php

namespace App\Controllers;

use App\Models\ProfilesModel;

class Profiles extends BaseController
{
    private $profiles;

    public function __construct()
    {
        $this->profiles = new ProfilesModel();
    }

    public function index()
    {
        $latest = $this->profiles->latest();

        $keyword = $this->request->getVar('s') ?: null;
        $profiles = $this->profiles->retrieve($keyword, 'paginate');
        $pager = $this->profiles->retrieve($keyword);

        $variable = [
            'page' => 'Profil Layanan Instansi',
            'profiles' => $profiles,
            'pager' => $pager,
            'keyword' => $keyword,
            'latest' => $latest
        ];

        return $this->view('public/profiles/list', $variable);
    }

    public function read($slug)
    {
        $detail = $this->profiles
            ->where('slug', $slug)
            ->first();

        if ($detail === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $previous = $this->profiles->previous($detail->id);
        $next = $this->profiles->next($detail->id);

        $variable = [
            'show2' => true,
            'page' => $detail->title,
            'detail' => $detail,
            'previous' => $previous,
            'next' => $next
        ];

        $this->profiles->increaseViews($slug);
        return $this->view('public/profiles/read', $variable);
    }
}
