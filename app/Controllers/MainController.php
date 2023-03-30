<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MainController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];
        return view('components/header_content', $data);
    }
}
