<?php

namespace App\Models;

use CodeIgniter\Model;

class SectorsModel extends Model
{
    protected $table = 'sectors';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name',
        'slug',
        'parent'
    ];
}
