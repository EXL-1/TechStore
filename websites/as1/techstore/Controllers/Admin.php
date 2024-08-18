<?php

namespace techstore\Controllers;

class Admin
{
    private $functions;
    public function __construct($functions)
    {
        $this->functions = $functions;
    }

    public function login()
    {   
        $this->functions->AlreadyLoggedIn();

        $error = $this->functions->signinUser('admin');

        return [
            'title' => 'Login Portal',
            'template' => 'login',
            'variables' => [
                'loginErr' => $error,
                'signin' => 'admin'
            ]
        ];
    }

    public function create()
    {   
        $this->functions->adminOnly();

        $error = $this->functions->createUser('admin');
        
        return [
            'title' => 'Manage Admins',
            'template' => 'register',
            'variables' => [
                'error' => $error,
                'type' => 'admin'
            ]
        ];
    }

    public function admincreated() {
        $this->functions->adminOnly();

        return [
            'title' => 'Admin Account Created',
            'template' => 'message',
            'variables' => [
                'title' => 'Admin Account Successfully Created',
                'message' => '<a href="/category/home" >Return to Homepage</a>'
            ]
        ];
    }
}

