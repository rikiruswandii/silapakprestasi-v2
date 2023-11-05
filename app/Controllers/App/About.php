<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;

class About extends BaseController
{
    public function index()
    {
        $variable = [
            'parent' => 'Kelola',
            'page' => 'Tentang',
            'content' => $this->settings->app_about
        ];

        return $this->view('app/about', $variable);
    }

    public function save()
    {
        // validation
        $validation = $this->validate([
            'content' => [
                'label' => 'Tentang',
                'rules' => 'required'
            ]
        ]);

        if ($validation == false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $content = $this->request->getPost('content');
        $update = $this->db->table('settings')
            ->where('code', 'app_about')
            ->update([
                'content' => $content
            ]);

        if ($update) {
            return redirect()->back()
                ->with('success', 'Berhasil memperbarui data Tentang.');
        }

        return redirect()->back()
            ->with('failed', 'Gagal memperbarui data Tentang.');
    }
}
