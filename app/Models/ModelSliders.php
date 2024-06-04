<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSliders extends Model
{
    protected $table = 'sliders';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'title',
        'content',
        'images'
    ];
}
