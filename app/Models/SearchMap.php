<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchMap extends Model
{
    protected $table = 'kmz'; // Sesuaikan dengan nama tabel Anda

    public function search($keyword)
    {
        // Lakukan pencarian berdasarkan kolom 'name' atau kolom lain yang sesuai
        return $this->like('name', $keyword)->orlike('district',$keyword)->findAll();
    }
}
