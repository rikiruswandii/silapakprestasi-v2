<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table = 'categories';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name',
        'slug'
    ];
}
