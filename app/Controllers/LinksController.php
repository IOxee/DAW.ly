<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClicksModel;
use App\Models\LinksModel;

class LinksController extends BaseController
{
    public function index()
    {
        $original_url = $this->request->getPost('url');
        $linksModel = new LinksModel();
        $short_link = $this->generateShortLink();
        $user_id = session()->get('id');
        $linksModel->insert([
            'link_code' => $short_link,
            'link' => $original_url,
            'user_id' => $user_id,
            'publish_date' => date('Y-m-d H:i:s'),
            'limit_date' => date('Y-m-d H:i:s', strtotime('+1 month'))
        ]);
        session()->set('short_link', base_url($short_link));
        return redirect()->to(base_url('/'));
    }

    public function redirect($short_link)
    {
        $linksModel = new LinksModel();
        $clickModel = new ClicksModel();
        $long_link = $linksModel->getLink($short_link);
        $description = $linksModel->getDescription($short_link);
        $isValid = $linksModel->isValid($short_link);
        if (!$isValid) {
            return redirect()->to(base_url('/'));
        } else {
            $clickModel->addClick($linksModel->getId($short_link));
            if ($description) {
                $data = [
                    'title' => 'Redirecting...',
                    'description' => $description,
                    'url' => $long_link
                ];
                echo view('components/redirect', $data);
            } else {
                return redirect()->to($long_link, NULL, 301);
            }
        }
    }

    public function shorten()
    {
        $post = $this->request->getPost([
            'domain',
            'description',
            'custom_url',
            'publish_date',
            'limit_date'
        ]);


        $linksModel = new LinksModel();
        $short_link = $this->generateShortLink();
        $user_id = session()->get('id');
        $linksModel->insert([
            'link' => $post['domain'],
            'link_code' => $post['custom_url'],
            'description' => $post['description'],
            'user_id' => $user_id,
            'publish_date' => $post['publish_date'],
            'limit_date' => $post['limit_date'],
        ]);
        session()->set('short_link', base_url($short_link));
        return redirect()->to(base_url('dashboard'));
    }


    public function show()
    {
        $link_code = $this->request->getGet('link_code');
        $linksModel = new LinksModel();
        $clicksModel = new ClicksModel();
        $link = $linksModel->getAllDataByCode($link_code);
        $link['linkVisits'] = $clicksModel->getClicksById($link['id']);

        echo view('components/dashboard',
        [
            'title' => 'Dashboard',
            'role' => $this->getMaxRole(),
            'setActive' => 'links',
            'links' => $this->getLinksByID(session()->get('id')),
            'linkdata' => $link
        ]);
    }

    public function updateLink()
    {
        $post = $this->request->getPost([
            'link',
            'code',
            'publish_date',
            'limit_date',
            'id'
        ]);

        $linksModel = new LinksModel();
        $result = $linksModel->updateLink(
            $post['id'],
            $post['link'], 
            $post['code'], 
            $post['publish_date'], 
            $post['limit_date']
        );

        if ($result) {
            $response = array('status' => 'success', 'message' => 'Enlace actualizado con éxito');
        } else {
            $response = array('status' => 'error', 'message' => 'Error al actualizar el enlace');
        }

        echo json_encode($response);
    }

    public function deleteLink()
    {
        $code = $this->request->getPost('link_code');
        $linksModel = new LinksModel();
        $result = $linksModel->deleteLinkByCode($code);

        return redirect()->to(base_url('manage'));
    }


    private function generateShortLink()
    {
        $short_link = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(7 / strlen($x)))), 1, 7);
        return $short_link;
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