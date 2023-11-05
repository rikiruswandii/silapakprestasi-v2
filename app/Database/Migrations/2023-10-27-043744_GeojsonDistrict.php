<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GeojsonDistrict extends Migration
{
    private $tableName = 'geojson';

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
