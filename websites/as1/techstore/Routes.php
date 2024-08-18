<?php

namespace techstore;

class Routes implements \Framework\Routes 
{
    public function getPage($route)
    {
        require '../database.php';

        $productTable = new \Framework\DatabaseTable($pdo, 'products', 'product_id');
        $categoryTable = new \Framework\DatabaseTable($pdo, 'category', 'category_id');
        $customerTable = new \Framework\DatabaseTable($pdo, 'customers', 'customer_id');
        $adminTable = new \Framework\DatabaseTable($pdo, 'admins', 'admin_id');
        $questionTable = new \Framework\DatabaseTable($pdo, 'questions', 'question_id');

        $functions = new \techstore\Functions($adminTable, $productTable, $customerTable, $categoryTable, $questionTable);
        
        $controllers = [];

        $controllers['product'] = new \techstore\Controllers\Product($functions);
        $controllers['category'] = new \techstore\Controllers\Category($functions);
        $controllers['customer'] = new \techstore\Controllers\Customer($functions);
        $controllers['admin'] = new \techstore\Controllers\Admin($functions);
        $controllers['question'] = new \techstore\Controllers\Question($functions);

        if ($route == '') {

            $page = $controllers['category']->home();

        } else {

            list($controllerName, $functionName) = explode('/', $route);
            $controller = $controllers[$controllerName];
            $page = $controller->$functionName();

        }
        return $page;
    }

}
