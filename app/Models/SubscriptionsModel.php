<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionsModel extends Model
{
    protected $table = 'subscriptions';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'email'
    ];
}
