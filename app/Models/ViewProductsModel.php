<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewProductsModel extends Model
{
    protected $table = "view_products";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    protected $allowedFields = [];
}
