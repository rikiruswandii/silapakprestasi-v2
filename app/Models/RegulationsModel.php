<?php

namespace App\Models;

use CodeIgniter\Model;

class RegulationsModel extends Model
{
    protected $table = 'regulations';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name',
        'file',
        'field',
        'type'
    ];
}
