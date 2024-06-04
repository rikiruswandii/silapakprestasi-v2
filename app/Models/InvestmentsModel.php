<?php

namespace App\Models;

use CodeIgniter\Model;

class InvestmentsModel extends Model
{
    protected $table = 'investments';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'title',
        'slug',
        'sector',
        'content',
      	'pdf',
        'thumbnail'
    ];

    public function increaseViews($slug)
    {
        $previous = get_cookie('read_investment');
        $time = time() + (10 * 365 * 24 * 60 * 60);
        setcookie('read_investment', $slug, $time);

        if ($previous !== $slug) {
            $this->where('slug', $slug);
            $this->increment('views');
        }
    }
}
