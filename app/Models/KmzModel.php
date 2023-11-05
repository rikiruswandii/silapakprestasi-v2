<?php

namespace App\Models;

use CodeIgniter\Model;

class KmzModel extends Model
{
    protected $table = 'kmz';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name',
        'type',
        'district',
        'file'
    ];
}
