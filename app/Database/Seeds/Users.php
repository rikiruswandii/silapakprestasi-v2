<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    private $tableName = 'users';
    private $tableRecords = [
        [
            'name' => 'Franklin Sedoyo',
            'login' => 'admin',
            'password' => '$2y$10$w.WYKAWIqOZQ1p65hhRO3umic17E2FTOMqM/c2urc9/l9zgm32KQC',
            'email' => 'touch@suluh.my.id',
            'role' => '1'
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
