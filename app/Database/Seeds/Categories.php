<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    private $tableName = 'categories';
    private $tableRecords = [
        [
            'name' => 'Harian',
            'slug' => 'daily'
        ],
        [
            'name' => 'Tautan',
            'slug' => 'link'
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
