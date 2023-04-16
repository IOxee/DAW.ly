<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLinks extends Migration
{
    public function up()
    {
        $this->forge -> addField([
            'id'   => [
                'type' =>'INT',   
                'auto_increment'=> true,
            ],
            'link' => ['type'=>'TEXT'],
            'link_code' => ['type'=>'VARCHAR(255)'],
            'description' => ['type'=>'TEXT', 'null' => true],
            'user_id' => ['type'=> 'INT(11)', 'null' => true],
            'publish_date' => ['type' => 'DATETIME'],
            'limit_date' => ['type' => 'DATETIME'],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('links');
    }

    public function down()
    {
        $this->forge->dropTable('links');
    }
}
