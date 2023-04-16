<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LinksModel;
use App\Models\UsersModel;
use SIENSIS\KpaCrud\Libraries\KpaCrud;

class DashboardController extends BaseController
{
    public function index()
    {
        echo view('components/dashboard',
        [
            'title' => 'Dashboard',
            'role' => $this->getMaxRole(),
            'setActive' => 'dashboard',
            'links' => null,
            'linkdata' => null
        ]);
    }

    public function createnew()
    {
        echo view('components/dashboard',
        [
            'title' => 'Dashboard',
            'role' => $this->getMaxRole(),
            'setActive' => 'createnew',
            'links' => null,
            'linkdata' => null
        ]);
    }

    public function manageLinks()
    {
        echo view('components/dashboard',
        [
            'title' => 'Dashboard',
            'role' => $this->getMaxRole(),
            'setActive' => 'links',
            'links' => $this->getLinksByID(session()->get('id')),
            'linkdata' => null
        ]);
    }

    public function adminusers()
    {
        $kpaUsers = new KpaCrud();
        $kpaGroups = new KpaCrud();
        $kpaRoles = new KpaCrud();
        $kpaUsers->setTable('users');
        $kpaUsers->setPrimaryKey('id');
        // username, email, role, created_at, updated_at
        $kpaUsers->setColumns([
            'username',
            'email',
            'role',
            'activated', // 1 is active, 0 is inactive
            'created_at',
            'updated_at'
        ]);
        $kpaUsers->setColumnsInfo([
            'username' => ['name'=>'Username'],
            'email' => ['name'=>'Email'],
            'role' => ['name'=>'Role'],
            'activated' => ['name'=>'Activated','type'=>KpaCrud::CHECKBOX_FIELD_TYPE],
            'created_at' => ['name'=>'Created at','type'=>KpaCrud::DATETIME_FIELD_TYPE],
            'updated_at' => ['name'=>'Updated at','type'=>KpaCrud::DATETIME_FIELD_TYPE],
        ]);

        $kpaRoles->setTable('roles');
        $kpaRoles->setPrimaryKey('id');
        $kpaRoles->setColumns([
            'name',
            'level'
        ]);
        $kpaRoles->setColumnsInfo([
            'name' => ['name'=>'Name'],
            'level' => ['name'=>'Level'],
            'description' => ['name'=>'Description'],
        ]);

        echo view('components/dashboard',
        [
            'title' => 'Dashboard',
            'role' => $this->getMaxRole(),
            'setActive' => 'administration',
            'links' => null,
            'linkdata' => null,
            'kpaUsers' => $kpaUsers->render(),
            'kpaRoles' => $kpaRoles->render(),
        ]);
    }

    public function users_posts()
    {        
        $post = $this->request->getPost([
            'data_id',
            'data_username',
            'data_email',
            'data_password',
            'data_role',
        ]);

        // update user
        if ($post['data_id'] != '') {
            $model = new UsersModel();
            $model->updateUserById(
                $post['data_id'],
                [
                    'username' => $post['data_username'],
                    'email' => $post['data_email'],
                    'password' => $post['data_password'],
                    'role' => $post['data_role'],
                ]
            );
        }

        return redirect()->to(base_url('dashboard'));
    }












    private function getMaxRole()
    {
        $role = session()->get('role');
        $max = 0;
        for ($i = 0; $i < count($role); $i++) {
            if ($role[$i]['level'] > $max) {
                $max = $role[$i]['level'];
            }
        }
        return $max;
    }

    private function getLinksByID($id)
    {
        $model = new LinksModel();
        $links = $model->getLinksByID($id);
        return $links;
    }
}
