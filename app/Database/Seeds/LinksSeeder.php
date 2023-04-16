<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LinksSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();
        $data = [
            [
                'link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'link_code' => 'PHPCourse',
                'description' => 'PHP Course - CodeIgniter 4',
                'user_id' => 1,
                'publish_date' => date('Y-m-d H:i:s'),
                'limit_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),

            ],
            // make me a clone of the link of above to redirect goog.e.com
            [
                'link' => 'https://www.google.com/',
                'link_code' => 'rwogw34',
                'description' => NULL,
                'user_id' => NULL,
                'publish_date' => date('Y-m-d H:i:s'),
                'limit_date' => date('Y-m-d H:i:s', strtotime('+1 month')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('links')->insertBatch($data);
        $this->db->enableForeignKeyChecks();
    }
}
