<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profiles extends Migration
{
    private $tableName = 'profiles';
    private $tableStructure = [
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'auto_increment' => true
        ],
        'title' => [
            'type' => 'VARCHAR',
            'constraint' => 255
        ],
        'slug' => [
            'type' => 'VARCHAR',
            'constraint' => 255
        ],
        'content' => [
            'type' => 'LONGTEXT'
        ],
        'pdf' => [
            'type' => 'VARCHAR',
            'constraint' => 128,
            'null' => true
        ],
        'thumbnail' => [
            'type' => 'VARCHAR',
            'constraint' => 128,
            'null' => true
        ],
        'views' => [
            'type' => 'INT',
            'constraint' => 11,
            'default' => 0
        ]
    ];
    private $indexColumn = [];
    private $uniqueColumn = [
        'slug'
    ];
    private $foreignKey = [];
    private $useTimestamps = true;
    private $useSoftDeletes = true;

    public function up()
    {
        // disable foreign key checks
        // prevent error foreign key
        $this->db->disableForeignKeyChecks();

        // add table structure
        $this->forge->addField($this->tableStructure);

        // if use timestamps
        // add created_at & updated_at columns
        if ($this->useTimestamps) {
            $this->forge->addField('created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP()');
            $this->forge->addField('updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()');
        }
        // if use soft deletes
        // add deleted_at column
        if ($this->useSoftDeletes) {
            $this->forge->addField('deleted_at DATETIME DEFAULT NULL');
        }

        // add primary key for 'id' column
        $this->forge->addKey('id', true);

        // add index keys
        if (count($this->indexColumn) > 0) {
            foreach ($this->indexColumn as $column) {
                $this->forge->addKey($column);
            }
        }

        // add unique keys
        if (count($this->uniqueColumn) > 0) {
            foreach ($this->uniqueColumn as $column) {
                $this->forge->addUniqueKey($column);
            }
        }

        // add foreign keys
        if (count($this->foreignKey) > 0) {
            foreach ($this->foreignKey as $field => $foreign) {
                $tableName = $foreign['table'];
                $fieldName = $foreign['field'];
                $onUpdate = $foreign['update'] ?? 'CASCADE';
                $onDelete = $foreign['delete'] ?? 'CASCADE';

                $this->forge->addForeignKey($field, $tableName, $fieldName, $onUpdate, $onDelete);
            }
        }

        // create table
        $this->forge->createTable($this->tableName, true);

        // enable again foreign key checks
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        // drop (delete) table
        $this->forge->dropTable($this->tableName, true);
    }
}
