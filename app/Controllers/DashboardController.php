<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LinksModel;
use App\Models\UsersModel;
use SIENSIS\KpaCrud\Libraries\KpaCrud;
use elFinder;
use elFinderConnector;

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
            'linkdata' => null,
            'connector' => base_url('/fileconnector'),
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
            'activated', // 1 is active, 0 is inactive
            'created_at',
            'updated_at'
        ]);
        $kpaUsers->setColumnsInfo([
            'username' => ['name'=>'Username'],
            'email' => ['name'=>'Email'],
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

    public function folders()
    {

    }

    public function getFile()
    {
        $varName=current_url(true)->setSegment(1,'')->getPath();
        $file = new \CodeIgniter\Files\File(WRITEPATH . "/uploads/" . urldecode($varName));
        if (!$file->isFile()){     // if (!is_file(WRITEPATH . "/uploads/" . $varName)){
            throw new \CodeIgniter\Exceptions\PageNotFoundException($varName . ' no found' . d($file));
        }

        // $filedata = readfile(WRITEPATH . "/uploads/" . $varName);
        $filedata = new \SplFileObject($file->getPathname(), "r");

        $data1 = $filedata->fread($filedata->getSize());

        return $this->response->setContentType($file->getMimeType())->setBody($data1);
    }

    public function connector()
    {
        if (session()->get('username') != 'admin') {
            $path = WRITEPATH . '/uploads/' . session()->get('username') . '/';
        } else {
            $path = WRITEPATH . '/uploads/';
        }
        
        $opts = array(
            'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => $path,
                    'URL' => base_url('fileget'),
                    // 'uploadDeny'    => array('all'),                  // All Mimetypes not allowed to upload
                    // 'uploadAllow'   => array('image', 'text/plain', 'application/pdf'), // Mimetype `image` and `text/plain` allowed to upload
                    // 'uploadOrder'   => array('deny', 'allow'),        // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => array($this, 'elfinderAccess'),
                    // disable and hide dot starting files (OPTIONAL)
                    'alias' => 'C:',
                    'attributes' => array(
                        array(
                            'pattern' => '/\.zop$/',
                            //You can also set permissions for file types by adding, for example, .jpg inside pattern.
                            'read' => false,
                            'write' => false,
                            'locked' => true,
                            'hidden' => true
                        ),
                        array(
                            'pattern' => '/personal.* /',
                            //comença per la paraula pesonal (expressio regular entre barres)
                            'read' => false,
                            'write' => false,
                            'locked' => true,
                            'hidden' => false
                        )
                    ),
                    // more elFinder options here
                )
            ),
        );
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }

    public function elfinderAccess($attr, $path, $data, $volume, $isDir, $relpath)
    {
        $basename = basename($path);

        if (substr_compare($basename, '.html', -5) === 0)
            return !($attr == 'read' || $attr == 'write');
        else {

            return $basename[0] === '.' // if file/folder begins with '.' (dot)
                && strlen($relpath) !== 1 // but with out volume root
                ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
                : null; // else elFinder decide it itself

        }
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
