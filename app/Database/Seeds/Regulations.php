<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Regulations extends Seeder
{
    private $tableName = 'regulations';
    private $tableRecords = [
        [
            'name' => 'Satuan Tugas Sistem Pengendalian Intern Pemerintah',
            'file' => '1633879496_df9bc57b6dad89198330.pdf',
            'field' => 'service',
            'type' => 'law'
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
