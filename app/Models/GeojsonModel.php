<?php

namespace App\Models;

use CodeIgniter\Model;

class GeojsonModel extends Model
{
    protected $table = 'geojson';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name',
        'type',
        'file'
    ];
}
