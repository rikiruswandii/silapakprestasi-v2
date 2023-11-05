<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewInvestmentsModel extends Model
{
    protected $table = 'view_investments';
    protected $returnType = 'object';
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;
    protected $allowedFields = [];

    public function retrieve($sector = null, $keyword = null, $type = 'pager')
    {
        if (is_null($keyword) === false) {
            $this->like('title', $keyword, 'both');
        }
        if (is_null($sector) === false) {
            if (is_array($sector)) {
                $this->whereIn('idsector', $sector);
            } else {
                $this->where('idsector', $sector);
            }
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
