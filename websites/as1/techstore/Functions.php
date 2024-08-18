<?php

namespace techstore;

trait TablesFunctions
{
    public $adminTable;
    public $productTable;
    public $customerTable;
    public $categoryTable;
    public $questionTable;

    public function __construct($adminTable, $productTable, $customerTable, $categoryTable, $questionTable)
    {
        $this->adminTable = $adminTable;
        $this->productTable = $productTable;
        $this->customerTable = $customerTable;
        $this->categoryTable = $categoryTable;
        $this->questionTable = $questionTable;
    }

    public function adminOnly()
    {
        if (!($_SESSION['loggedin'] ?? '') || !($_SESSION['account_type'] == 'admin')) {
            header('location: /customer/accessdenied');
        }
    }

    public function customerOnly()
    {
        if (!($_SESSION['loggedin'] ?? '') || $_SESSION['account_type'] == 'admin') {
            header('location: /customer/accessdenied');
        }
    }

    public function AlreadyLoggedIn()
    {
        if ($_SESSION['loggedin'] ?? '') {
            header('location: /customer/accessdenied');
        }
    }
    public function notEmptyCheck($field, $value)
    {

        if (empty($field)) {
            $error = $value;
        } else {
            $error = "";
        }

        return $error;
    }

    public function findAccountInfo($value, $field)
    {

        if (($value == 'admin')) {
            $user = $this->adminTable->find('email', $field);
        } else {
            $user = $this->customerTable->find('email', $field);
        }

        return $user;
    }

    public function signinUser($value)
    {
        $error = "";
        if (isset($_POST['submit'])) {

            $user = $this->findAccountInfo($value, $_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {

                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $user['firstname'] . ' ' . $user['surname'];
                $_SESSION['account_type'] = $value;
                $_SESSION['email'] = $_POST['email'];

                header('location: /category/home');
            } else {

                $error = 'You did not enter the correct email and password';
            }
        }

        return $error;
    }

    public function createUser($value)
    {

        $error = "";
        $token = bin2hex(random_bytes(24));

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $user = $this->findAccountInfo($value, $_POST['email']);
        
            if (strlen($_POST["password"]) < 8 || strlen($_POST["firstname"]) < 3 || strlen($_POST["surname"]) < 3) {
                $error = 'Password or Names are too short!';
            }
            if (
                !(preg_match("/^[a-zA-Z- ']*$/", $_POST["firstname"])) || !(preg_match("/^[a-zA-Z- ']*$/", $_POST["surname"])) ||
                !(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) || strtolower($user['email'] ?? '') == strtolower($_POST['email'] ?? '')
            ) {

                $error = 'Names contains invalid characters or either the email is invalid!';
            }

            if (empty($_POST["firstname"]) || empty($_POST["surname"]) || empty($_POST["email"]) || empty($_POST["password"])) {
                $error = 'One or more fields were left blank!';
            }

            $_SESSION['token'] = $token;
        }

        if ($error == "" && isset($_SESSION['token']) == $token) {

            $date = new \DateTime();
            $date = $date->format("Y-m-d");

            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $values = [
                "firstname" => $_POST['firstname'],
                "surname" => $_POST['surname'],
                "email" => $_POST['email'],
                "password" => $hash,
                "date_created" => $date
            ];

            unset($_SESSION['token']);

            if ($value == 'admin') {
                $this->adminTable->insert($values);
                header('location: /admin/admincreated');
            } else {
                $this->customerTable->insert($values);
                header('location: /customer/created');
            }
        } else {
            unset($_SESSION['token']);
        }
        return $error;
    }
    public function notEmptyCheckMutiple($fields, $value)
    {
        foreach ($fields as $field) {
            if (empty($field)) {
                $error = $value;
            } else {
                $error = "";
            }
        }
        return $error;
    }
    public function signOut()
    {
        unset($_SESSION['loggedin']);
        unset($_SESSION['name']);
        unset($_SESSION['account_type']);
        unset($_SESSION['email']);
    }

    public function notFound($value)
    {
        if ((!(isset($_GET['id'])) || $_GET['id'] == null || intval($_GET['id']) == 0)) {
            header('location: ' . $value . '');
        }
    }

    public function valueEmpty($field, $value)
    {
        if (empty($field) || $field == null) {
            header('location: ' . $value . '');
        }
    }
}

class Functions
{
    use TablesFunctions;
}
