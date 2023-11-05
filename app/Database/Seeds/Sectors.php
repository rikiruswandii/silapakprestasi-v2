<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Sectors extends Seeder
{
    private $tableName = 'sectors';
    private $tableRecords = [
        [
            'name' => 'Industri',
            'slug' => 'industry',
            'parent' => null
        ],
        [
            'name' => 'Perdagangan dan Jasa',
            'slug' => 'trade-services',
            'parent' => null
        ],
        [
            'name' => 'Pariwisata',
            'slug' => 'tour',
            'parent' => null
        ],
        [
            'name' => 'Pertanian, Perikanan dan Peternakan',
            'slug' => 'agriculture-fisheries',
            'parent' => null
        ],
        [
            'name' => 'UMKM',
            'slug' => 'umkm',
            'parent' => null
        ],
        [
            'name' => 'Bukit Indah',
            'slug' => 'bukit-indah',
            'parent' => 1
        ],
        [
            'name' => 'Jatiluhur',
            'slug' => 'jatiluhur',
            'parent' => 1
        ],
        [
            'name' => 'Campaka',
            'slug' => 'campaka',
            'parent' => 1
        ]
    ];

    public function run()
    {
        // disable foreign key checks
        // prevent error foreign key
        $this->db->disableForeignKeyChecks();

        // insert data (multiple) into table
        $this->db->table($this->tableName)->insertBatch($this->tableRecords);

        // enable again foreign key checks
        $this->db->enableForeignKeyChecks();
    }
}
