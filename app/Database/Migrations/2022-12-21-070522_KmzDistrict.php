<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KmzDistrict extends Migration
{
    private $tableName = 'kmz';

    public function up()
    {
        $this->forge->addColumn($this->tableName, [
            'district' => [
                'type' => 'integer',
                'constraint' => 6,
                'after' => 'file',
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->tableName, 'district');
    }
}
