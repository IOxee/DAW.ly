<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClicksMigration extends Migration
{
    public function up()
    {
        // id, id link, ip, date, user agent
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'link_id' => [
                'type' => 'INT(11)',
            ],
            'ip' => [
                'type' => 'VARCHAR(255)',
            ],
            'date' => [
                'type' => 'DATETIME'
            ],
            'user_agent' => [
                'type' => 'VARCHAR(255)',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('link_id', 'links', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('clicks');
    }

    public function down()
    {
        $this->forge->dropTable('clicks');
    }
}
