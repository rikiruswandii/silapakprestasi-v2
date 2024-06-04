<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = "settings";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        "code",
        "content"
    ];
}
