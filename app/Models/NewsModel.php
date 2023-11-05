<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'category'
    ];

    public function increaseViews($slug)
    {
        $previous = get_cookie('read_news');
        $time = time() + (10 * 365 * 24 * 60 * 60);
        setcookie('read_news', $slug, $time);

        if ($previous !== $slug) {
            $this->where('slug', $slug);
            $this->increment('views');
        }
    }
}
