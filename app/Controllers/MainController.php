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
        return view('components/main_page', $data);
    }

    public function destroy_session()
    {
        d('destroyed');
        session()->remove('short_link');
    }
}
