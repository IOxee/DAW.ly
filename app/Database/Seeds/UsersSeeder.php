<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@dawly.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'activated' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'editor',
                'email' => 'editor@dawly.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'activated' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'user',
                'email' => 'user@dawly.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'activated' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'guest',
                'email' => 'guest@dawyly.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'activated' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
