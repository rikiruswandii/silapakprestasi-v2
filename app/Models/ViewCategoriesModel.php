<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewCategoriesModel extends Model
{
    protected $table = "view_categories";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    protected $allowedFields = [];
}
