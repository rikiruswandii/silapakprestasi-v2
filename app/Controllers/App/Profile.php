<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Profile extends BaseController
{
    private $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Panel',
            'page' => 'Profil & Akun'
        ];

        return $this->view('app/profile', $variable);
    }

    public function save()
    {
        $validation = $this->validate([
            'name' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|max_length[64]|alpha_space'
            ],
            'email' => [
                'label' => 'Alamat Surel',
                'rules' => 'required|valid_email'
            ],
            'avatar' => [
                'label' => 'Foto Profil',
                'rules' => 'ext_in[avatar,jpg,jpeg,png]|max_size[avatar,2048]'
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
        $email = $this->request->getPost('email');

        $avatar = $this->request->getFile('avatar');
        if ($avatar->getSize() > 0) {
            $filename = $avatar->getRandomName();
            $avatar->move('uploads/avatars/', $filename);

            @unlink('uploads/avatars/' . $this->userdata->avatar);
        }

        $data = [
            'name' => trim($name),
            'email' => trim($email),
            'avatar' => $filename ?? $this->userdata->avatar
        ];
        $update = $this->users->update($this->userdata->id, $data);

        if ($update) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil memperbarui profil & akun.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal memperbarui profil & akun.');
    }

    public function password()
    {
        $validation = $this->validate([
            'oldpass' => [
                'label' => 'Kata Sandi Lama',
                'rules' => 'required'
            ],
            'newpass' => [
                'label' => 'Kata Sandi Baru',
                'rules' => 'required|min_length[6]'
            ],
            'repass' => [
                'label' => 'Kata Sandi Baru',
                'rules' => 'required|matches[newpass]'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $oldpass = $this->request->getPost('oldpass');
        $newpass = $this->request->getPost('repass');

        $hashed = $this->userdata->password;
        if (password_verify($oldpass, $hashed) === false) {
            return redirect()
                ->back()
                ->with('failed', 'Kata sandi lama tidak benar.');
        }

        $update = $this->users->update($this->userdata->id, [
            'password' => password_hash($newpass, PASSWORD_BCRYPT)
        ]);

        if ($update) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil memperbarui kata sandi.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal memperbarui kata sandi.');
    }
}
