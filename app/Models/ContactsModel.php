<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactsModel extends Model
{
    protected $table = 'contacts';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name',
        'surname',
        'email',
        'phone',
        'message'
    ];
}
