<?php

namespace techstore\Controllers;

class Customer
{

    private $functions;
    public function __construct($functions)
    {
        $this->functions = $functions;
    }
    public function login()
    {   
        $this->functions->AlreadyLoggedIn();

        $error = $this->functions->signinUser('customer');

        return [
            'title' => 'Login Portal',
            'template' => 'login',
            'variables' => [
                'loginErr' => $error,
                'signin' => 'customer'
            ]
        ];
    }

    public function register()
    {   
        $this->functions->AlreadyLoggedIn();

       $error = $this->functions->createUser('customer');

        return [
            'title' => 'register',
            'template' => 'register',
            'variables' => [
                'error' => $error,
                'type' => 'customer'
            ]
        ];
    }

    public function signout()
    {

        $this->functions->signOut();

        return [
            'title' => 'Signed Out',
            'template' => 'message',
            'variables' => [
                'title' => 'Signed Out',
                'message' => '<a href="/category/home" >Return to HomePage</a>'
            ]
        ];
    }

    public function accessdenied()
    {
        return [
            'title' => 'Access Denied',
            'template' => 'message',
            'variables' => [
                'title' => 'Access Denied',
                'message' => '<a href="/category/home" >Return to Homepage</a>'
            ]
        ];
    }

    public function created()
    {
        return [
            'title' => 'Account Created',
            'template' => 'message',
            'variables' => [
                'title' => 'Account Successfully Created',
                'message' => '<a href="/customer/login" >Sign in into your Account</a>'
            ]
        ];
    }
}
