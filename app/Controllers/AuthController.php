<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupsModel;
use App\Models\UsersModel;

class AuthController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        echo view(
            'auth/login',
            $data
        );
    }

    /*
        $routes->get('login', 'AuthController::index');
        $routes->post('login', 'AuthController::login');
        $routes->get('logout', 'AuthController::logout');
        $routes->get('register', 'AuthController::registerview');
        $routes->post('register', 'AuthController::register');
    */

    public function login()
    {
        // if user is in database but not activated yet dont let him login
        $validationRules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid'
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters'
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            $data = [
                'title' => 'Login',
                'validation' => $this->validator
            ];
            return view('auth/login', $data);
        } else {
            $model = new UsersModel();
            $groupsModel = new GroupsModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = $model->where('email', $email)->first();
            $role = $groupsModel->getRolesByUserId($user['id']);

            if (!$user) {
                $data = [
                    'title' => 'Login',
                    'error' => 'Email not found',
                    'validation' => $this->validator
                ];
                session()->setFlashdata('error', 'Email not found');
                return view('auth/login', $data);
            }
            if ($user['activated'] == 0) {
                $data = [
                    'title' => 'Login',
                    'error' => 'Account not activated',
                    'validation' => $this->validator
                ];
                session()->setFlashdata('error', 'Account not activated');
                return view('auth/login', $data);
            } else {
                $checkPassword = password_verify($password, $user['password']);
                if ($checkPassword) {
                    $sessionData = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role' => $role,
                        'isLoggedIn' => true
                    ];
                    session()->set($sessionData);
                    return redirect()->to(base_url('dashboard'));
                } else {
                    $data = [
                        'title' => 'Login',
                        'error' => 'Wrong password',
                        'validation' => $this->validator
                    ];
                    return view('auth/login', $data);
                }
            }
        }
    }

    public function registerview()
    {
        echo view(
            'auth/register',
            $this->makeCaptcha()
        );
    }

    public function register() 
    {
        $validationRules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username is required',
                    'min_length' => 'Username must be at least 3 characters',
                    'max_length' => 'Username must be at most 20 characters',
                    'is_unique' => 'Username already exists'
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Email is not valid',
                    'is_unique' => 'Email already exists'
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{6,}$/]',
                'errors' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters',
                    'regex_match' => 'Password must contain at least one number, one capital letter, one tiny letter and one special character',
                ],
            ],
            'password_confirm' => [
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Password Confirmation is required',
                    'matches' => 'Password Confirmation does not match Password',
                ],
            ],
            'captcha' => [
                'label' => 'Captcha',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio',
                    'matches' => 'El campo {field} no coincide con el texto de la imagen',
                ],
            ]
        ];

        if (!$this->validate($validationRules)) {
            $data = [
                'title' => 'Register',
                'validation' => $this->validator->getErrors()
            ];
            $data = array_merge($data, $this->makeCaptcha());
            return redirect()->back()->withInput();
        } else {
            $captchaText = session()->get('captcha_text');
            $post = $this->request->getPost([
                'username',
                'email',
                'password',
            ]);
            if ($post['captcha'] != $captchaText) {
                session()->setFlashdata('error', ['captcha' => 'El campo Captcha no coincide con el texto de la imagen']);
                return redirect()->back()->withInput();
            }
            $model = new UsersModel();
            $newData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            ];

            $user = $model->insert($newData);   
            if ($user) {
                return redirect()->to(base_url('/'));
            } else {
                return redirect()->back()->withInput();
            }
        }

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
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

        session()->set('captcha_text', $timage->text);
        return $data;
    }
}
