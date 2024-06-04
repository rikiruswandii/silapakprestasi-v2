<?php

namespace App\Models;

use CodeIgniter\Model;

class InnovationsModel extends Model
{
    protected $table = 'innovations';
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'pdf',
        'instance',
        'thumbnail'
    ];

    public function increaseViews($slug)
    {
        $previous = get_cookie('read_innovation');
        $time = time() + (10 * 365 * 24 * 60 * 60);
        setcookie('read_innovation', $slug, $time);

        if ($previous !== $slug) {
            $this->where('slug', $slug);
            $this->increment('views');
        }
    }

    public function retrieve($keyword = null, $type = 'pager')
    {
        if (is_null($keyword) === false) {
            $this->like('title', $keyword, 'both');
        }
        $this->orderBy('id', 'DESC');

        if ($type === 'pager') {
            return $this->pager;
        }
        return $this->paginate(6);
    }

    public function latest($show = 3)
    {
        $this->orderBy('id', 'DESC');
        return $this->findAll($show);
    }

    public function previous($current)
    {
        $this->where("id < $current", null, false);
        $this->orderBy('id', 'DESC');

        return $this->first();
    }

    public function next($current)
    {
        $this->where("id > $current", null, false);
        $this->orderBy('id', 'ASC');

        return $this->first();
    }
}
