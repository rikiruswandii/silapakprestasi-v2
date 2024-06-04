<?php

namespace App\Controllers\App;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use Hermawan\DataTables\DataTable;

class Users extends BaseController
{
    private $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        $variable = [
            'parent' => 'Kelola',
            'page' => 'Pengguna'
        ];

        return $this->view('app/users', $variable);
    }

    public function datatable()
    {
        $users = $this->users
            ->where('deleted_at IS NULL', null, false)
            ->builder();

        return DataTable::of($users)
            ->addNumbering('no')
            ->add('action', function ($row) {
                $edit = [
                    'class' => 'text-warning edit-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-form',
                    'data-bs-backdrop' => 'static',
                    'data-id' => $row->id,
                    'data-name' => $row->name,
                    'data-username' => $row->login,
                    'data-email' => $row->email,
                    'data-role' => $row->role,
                    'data-hidden' => 'username'
                ];
                $delete = [
                    'class' => 'text-danger delete-button',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-danger',
                    'data-bs-backdrop' => 'static',
                    'data-name' => $row->name,
                    'data-url' => base_url(
                        $this->settings->app_prefix . '/users/delete/' . $row->id
                    ),
                ];

                $html = '<div class="btn-list flex-nowrap">';
                $html .= anchor('javascript:void(0)', tabler_icon('edit'), $edit);
                $html .= anchor('javascript:void(0)', tabler_icon('trash'), $delete);
                $html .= '</div>';

                return $html;
            })
            ->format('role', function ($value) {
                return permission($value);
            })
            ->hide('id')
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'DESC');
            })
            ->toJson(true);
    }

    public function insert()
    {
        $validation = $this->validate([
            'username' => [
                'label' => 'Nama Pengguna',
                'rules' => 'required|max_length[16]|is_unique[users.login]|alpha_numeric'
            ],
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'required|min_length[6]'
            ],
            'name' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|max_length[64]|alpha_space'
            ],
            'email' => [
                'label' => 'Alamat Surel',
                'rules' => 'required|valid_email|is_unique[users.email]'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');

        $insert = $this->users->insert([
            'email' => $email,
            'login' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'name' => $name,
            'role' => 1
        ]);

        if ($insert) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil menambahkan data Pengguna.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menambahkan data Pengguna.');
    }

    public function update($id)
    {
        $detail = $this->users
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal mengubah data Pengguna.');
        }

        $validation = $this->validate([
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'permit_empty|min_length[6]'
            ],
            'name' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|max_length[64]|alpha_space'
            ],
            'email' => [
                'label' => 'Alamat Surel',
                'rules' => 'required|valid_email'
            ]
        ]);

        if ($validation === false) {
            $errors = $this->validator->getErrors();
            $error = array_shift($errors);

            return redirect()
                ->back()
                ->with('failed', $error);
        }

        $password = $this->request->getPost('password');
        $password = trim($password) ?
            password_hash($password, PASSWORD_BCRYPT) :
            $detail->password;

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');

        $update = $this->users->update($id, [
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'role' => 1
        ]);

        if ($update) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil mengubah data Pengguna.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal mengubah data Pengguna.');
    }

    public function delete($id)
    {
        $detail = $this->users
            ->where('id', $id)
            ->first();

        if ($detail === null) {
            return redirect()
                ->back()
                ->with('failed', 'Gagal menghapus data Pengguna.');
        }

        // prevent unique fields
        $hashid = hashids($id);
        $this->users->update($id, [
            'login' => $hashid,
            'email' => strtolower($hashid) . '@removed.co'
        ]);

        $delete = $this->users->delete($id);
        // delete avatars
        @unlink('uploads/avatars/' . $detail->avatar);

        if ($delete) {
            return redirect()
                ->back()
                ->with('success', 'Berhasil menghapus data Pengguna.');
        }

        return redirect()
            ->back()
            ->with('failed', 'Gagal menghapus data Pengguna.');
    }
}
