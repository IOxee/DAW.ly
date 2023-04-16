<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersMigration extends Migration
{
    public function up()
    {
        $this->forge -> addField([
            'id'   => [
                'type' =>'INT',   
                'auto_increment'=> true,
            ],
            'username' => ['type'=>'VARCHAR(255)'],
            'email' => ['type'=>'VARCHAR(255)'],
            'password' => ['type'=>'VARCHAR(255)'],
            'activated' => ['type' =>'INT(1)', 'default' => 0],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
