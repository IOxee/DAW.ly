<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RolMigration extends Migration
{
    public function up()
    {
        // id, name, level, created_at, updated_at, deleted_at
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR(255)',
            ],
            'level' => [
                'type' => 'INT(11)',
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ],
            'deleted_at' => [
                'type' => 'DATETIME'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
