<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MainController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'captcha' => $this->makeCaptcha()
        ];
        return view('components/main_page', $data);
    }

    public function destroy_session()
    {
        d('destroyed');
        session()->remove('short_link');
    }

    private function makeCaptcha()
    {
        $config = [
            "textColor"=>'#000000',
            "backColor"=>'#ffffff',
            "noiceColor"=>'#162453',
            "imgWidth"=>180,
            "imgHeight"=>40,
            "noiceLines"=>15,
            "noiceDots"=>10,
            "length" => 6,
            "expiration"=>5*MINUTE
        ];
        $timage = new \App\Libraries\Text2Image($config);
        
        $data = [
            'title' => 'Register',
            'captcha' => $timage->captcha()->html(),
            'captchaText' => $timage->textToImage()->html(),
            'text' => $timage->text
        ];

        session()->set('captcha_main', $timage->text);
        return $data;
    }
}
