<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Install extends Seeder
{
    public function run()
    {
        $this->call('UsersSeeder');
        $this->call('RolesSeeder');
        $this->call('GroupsSeeder');
        $this->call('LinksSeeder');
    }
}
