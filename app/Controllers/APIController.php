<?php

namespace App\Controllers;

use App\Models\GroupsModel;
use App\Models\LinksModel;
use App\Controllers\LinksController;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UsersModel;
use Config\APIJwt;
use Firebase\JWT\JWT;

class APIController extends ResourceController
{      
    public function login()
    {
        helper("form");

        $rules = [
            'email' => 'required',
            'password' => 'required|min_length[4]'
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        
        $model = new UsersModel();
        $groupsModel = new GroupsModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->first();
        $role = $groupsModel->getRolesByUserId($user['id']);
        $accountActivated = $model->isAccountActivated($user['id']);

        if (!$user)
            return $this->failNotFound('Email Not Found');

        $verify = password_verify($this->request->getVar('password'), $user['password']);

        if (!$verify)
            return $this->fail('Wrong Password');

        if (!$accountActivated)
            return $this->fail('Account not activated');

        /****************** GENERATE TOKEN ********************/
        helper("jwt");
        $APIGroupConfig = "default";
        $cfgAPI = new APIJwt($APIGroupConfig);

        $data = array(
            "uid" => $user['id'],
            "name" => $user['username'],
            "email" => $user['email']
        );

        $token = newTokenJWT($cfgAPI->config(), $data);
        /****************** END TOKEN GENERATION **************/

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'User logged In successfully',
            'token' => $token,
            'data' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' =>[
                    'id' => $role[0]['role_id'],
                    'name' => $role[0]['name'],
                    'level' => $role[0]['level']
                ]
            ]
        ];
        return $this->respondCreated($response);
    }

    public function getDawlyURL($id = null)
    {
        $model = new LinksModel();
        $long_link = $model->getLink($id);
        $title = $model->getTitle($id);
        $description = $model->getDescription($id);
        $isValid = $model->isValid($id);

        if ($isValid) {
            $response = [
                'status' => 200,
                'error' => false,
                'messages' => 'Link found',
                'data' => [
                    "long_link" => $long_link,
                    "description" => $description,
                    "title" => $title
                ]
            ];
            return $this->respond($response);
        } else {
            $response = [
                'status' => 404,
                'error' => true,
                'messages' => 'Link not found',
                'data' => []
            ];
            return $this->respond($response);
        }
    }

    public function getDawlyOptions() 
    {
        if ($this->request->getPost('id') != null) {
            $id = $this->request->getPost('id');
        } else {
            $id = $this->request->getGet('id');
        }

        $model = new LinksModel();
        $userModel = new UsersModel();
        $groupModel = new GroupsModel();
        $long_link = $model->getLink($id);
        $linkData = $model->getAllDataByCode($id);
        $description = $model->getDescription($id);
        $isValid = $model->isValid($id);

        if ($this->request->header("token-data") != null) {
            $token_data = json_decode($this->request->header("token-data")->getValue());
            $userData = $userModel->getAllDataById($token_data->uid);
            $maxGroup = $groupModel->getMaxRole($token_data->uid);
            $userId = $token_data->uid;
        } else {
            $token_data = null;
            $userData = null;
            $maxGroup = 0;
            $userId = null;
        };


        if ($isValid) {
            if ($maxGroup >= 10) {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'Link found (admin)',
                    'data' => [
                        "long_link" => $long_link,
                        "description" => $description,
                        "created_at" => $userModel->getAllDataById($token_data->uid)['created_at'],
                        "link_data" => $linkData,
                        "id" => $id,
                        "token" => $token_data
                    ]
                ];
                return $this->respondCreated($response);
            } else {
                if ($userId == $linkData['user_id']) {
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'messages' => 'Link found (owner)',
                        'data' => [
                            "long_link" => $long_link,
                            "description" => $description,
                            "link_data" => $linkData,
                        ]
                    ];
                    return $this->respondCreated($response);
                } else {
                    $response = [
                        'status' => 200,
                        'error' => false,
                        'messages' => 'Link found (not owner)',
                        'data' => [
                            "long_link" => $long_link,
                            "description" => $description,
                            "token" => $token_data,
                        ]
                    ];
                    return $this->respondCreated($response);
                }
            }
        } else {
            $response = [
                'status' => 404,
                'error' => true,
                'messages' => 'Link not found',
                'data' => []
            ];
            return $this->respond($response);
        }
    }

    public function newDawly() 
    {
        $rules = [
            'url' => 'required|valid_url'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 400,
                'error' => true,
                'messages' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($response);
        }

        $original_url = $this->request->getPost();
        $linksModel = new LinksModel();
        $short_link = $this->generateShortLink();
        $linksModel->insert([
            'link_code' => $short_link,
            'link' => $original_url,
            'user_id' => null,
            'publish_date' => date('Y-m-d H:i:s'),
            'limit_date' => date('Y-m-d H:i:s', strtotime('+1 month'))
        ]);

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Link created successfully',
            'data' => [
                "short_link" => $short_link,
                "long_link" => $original_url
            ]
        ];

        return $this->respondCreated($response);
    }

    public function users() 
    {
        $userModel = new UsersModel();
        $groupModel = new GroupsModel();
        $token_data = json_decode($this->request->header("token-data")->getValue());
        $userId = $token_data->uid;
        $userData = $userModel->getAllDataById($userId);
        $maxGroup = $groupModel->getMaxRole($userId);

        if ($maxGroup >= 10) {
            $response = [
                'status' => 200,
                'error' => false,
                'messages' => 'Users found (admin)',
                'data' => [
                    "users" => $userModel->getAllData(),
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Unauthorized',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }

    public function user_role()
    {
        $userId = $this->request->getPost('id');
        $groupModel = new GroupsModel();
        $userModel = new UsersModel();

        $token_data = json_decode($this->request->header("token-data")->getValue());
        $userId = $token_data->uid;
        $maxGroup = $groupModel->getMaxRole($userId);

        if ($maxGroup >= 10) {
            $response = [
                'status' => 200,
                'error' => false,
                'messages' => 'User role found (admin)',
                'data' => [
                    "user" => $groupModel->getAllRoles($userId),
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Unauthorized',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }

    public function register()
    {
        $post = $this->request->getPost();
        $rules = [
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
                'rules' => 'required|min_length[6]', // |regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{6,}$/]
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
            ]
        ];

        $validationRulesErrors = [];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 400,
                'error' => true,
                'messages' => 'Validation error',
                'validation' => $this->validator->getErrors()
            ];
            return $this->respondCreated($response);
        } else {
            $userModel = new UsersModel();
            $groupModel = new GroupsModel();
            $userModel->insert([
                'username' => $post['username'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $userId = $userModel->getInsertID();
            $groupModel->insert([
                'user_id' => $userId,
                'role_id' => 1
            ]);

            $response = [
                'status' => 200,
                'error' => false,
                'messages' => 'User created successfully',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }

    public function edit_user()
    {
        $token = json_decode($this->request->header("token-data")->getValue());
        $userId = $token->uid;
        $userEmail = $token->email;
        $userModel = new UsersModel();
        $oldPassword = $userModel->getPassword($userId);
        $groupModel = new GroupsModel();
        

        $maxGroup = $groupModel->getMaxRole($userId);

        if ($maxGroup >= 10) {
            $userModel->updateByMail(
                $this->request->getVar('email'),
                [
                    'username' => $this->request->getVar('usr'),
                    'email' => $this->request->getVar('new_email') ?? $userEmail,
                    'password' =>   $this->request->getVar('password') == '' ? $oldPassword : password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );
            $response = [
                'status' => 200,
                'error' => false,
                'messages' => 'User updated successfully (Admin)',
                'data' => [
                    'group' => $maxGroup
                ]
            ];
            return $this->respondCreated($response);
        } else if ($userEmail == $this->request->getVar('email')) {
            if (password_verify(password_hash($this->request->getVar('password'), PASSWORD_BCRYPT), $oldPassword['password'])) {
                $userModel->updateByMail(
                    $this->request->getVar('email'),
                    [
                        'username' => $this->request->getVar('username'),
                        'email' => $this->request->getVar('new_email') ?? $userEmail,
                        'password' => $this->request->getVar('new_password') == '' ? $oldPassword : password_hash($this->request->getVar('new_password'), PASSWORD_BCRYPT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'User updated successfully (User)',
                    'data' => []
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    'status' => 400,
                    'error' => true,
                    'messages' => 'Wrong password',
                    'data' => []
                ];
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Unauthorized',
                'data' => []
            ];
            return $this->respondCreated($response);
        }
    }

    public function is_in_group()
    {
        $token = json_decode($this->request->header("token-data")->getValue());
        $userId = $token->uid;
        $groupModel = new GroupsModel();
        $maxGroup = $groupModel->getMaxRole($userId);

        $post = $this->request->getPost();

        if ($maxGroup >= 10) {
            $isInGroup = $groupModel->isInGroup($post['user_id'], $post['role_id']);
            if ($isInGroup) {
                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'User is in group',
                    'data' => [
                        'is_in_group' => $isInGroup
                    ]
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    'status' => 400,
                    'error' => true,
                    'messages' => 'User is not in group',
                    'data' => []
                ];
                return $this->respondCreated($response);
            }
        } else {
            $response = [
                'status' => 401,
                'error' => true,
                'messages' => 'Unauthorized',
                'data' => [
                    'token' => $token,
                    'maxGroup' => $maxGroup
                ]
            ];
            return $this->respondCreated($response);
        }
    }

    public function create()
    {
        // create a new dawly checking if user is logged with token and post has title, description and url, publish_date and limit_date
        $post = $this->request->getPost();
        $token = json_decode($this->request->header("token-data")->getValue());

        $userId = $token->uid;

        $linksModel = new LinksModel();
        $short_link = $this->generateShortLink();

        $rules = [
            'domain' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 400,
                'error' => true,
                'messages' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($response);
        } else {
            $linksModel->insert([
                'link' => $post['domain'],
                'link_code' => $short_link,
                'title' => $post['title'],
                'description' => $post['description'],
                'user_id' => $userId,
                'publish_date' => $post['publish_date'] == '' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($post['publish_date'])),
                'limit_date' => $post['limit_date'] == '' ?  date('Y-m-d H:i:s', strtotime('+1 month')) : date('Y-m-d H:i:s', strtotime($post['limit_date'])),
            ]);
    
            $response = [
                'status' => 200,
                'error' => false,
                'messages' => [
                    'header' => 'Link created successfully',
                    'body' => 'Your link is: ',
                    'link' => base_url($short_link)
                ],
                'data' => []
            ];
            
            return $this->respondCreated($response);
        }
    }

    public function editlink()
    {
        $post = $this->request->getPost();
        $userModel = new UsersModel();
        $groupModel = new GroupsModel();
        $linksModel = new LinksModel();
        $token = json_decode($this->request->header("token-data")->getValue());

        $userId = $token->uid;
        $userEmail = $token->email;
        $maxGroup = $groupModel->getMaxRole($userId);

        $rules = [
            'short_link' => 'required',
            'domain' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status' => 400,
                'error' => true,
                'messages' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($response);
        } else {
            if ($maxGroup >= 10) {
                $linksModel->updateByShortLink(
                    $post['short_link'],
                    [
                        'link' => $post['domain'],
                        'title' => $post['title'],
                        'description' => $post['description'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );

                $response = [
                    'status' => 200,
                    'error' => false,
                    'messages' => 'Link updated successfully',
                    'data' => []
                ];
                return $this->respondCreated($response);

            } else {
                $response = [
                    'status' => 401,
                    'error' => true,
                    'messages' => 'Unauthorized',
                    'data' => []
                ];

                $this->respondCreated($response);
            }
        }
    }

    private function generateShortLink()
    {
        $short_link = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(7 / strlen($x)))), 1, 7);
        return $short_link;
    }
}