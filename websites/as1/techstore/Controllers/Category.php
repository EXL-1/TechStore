<?php

namespace techstore\Controllers;

class Category
{

    private $functions;
    public function __construct($functions)
    {
        $this->functions = $functions;
    }

    public function category()
    {
       
        $this->functions->notFound('/category/nocategoryfound');  
        $this->functions->productTable->findMutiple('category_id', $_GET['id']);

        if (isset($_GET['id'])) {
           $products = $this->functions->productTable->findMutiple('category_id', $_GET['id']);
           $products_count = $this->functions->productTable->count('category_id', $_GET['id']);
           $category = $this->functions->categoryTable->find('category_id', $_GET['id']);
        } 
        
        $this->functions->valueEmpty($products, '/category/nocategoryfound');

        return [
            'title' => 'Products',
            'template' => 'home',
            'variables' => [
                'products' => $products,
                'products_count' => $products_count,
                'category' => $category,
                'page' => 'products'
            ]
        ];
    }

    public function managecategory()
    {
        $this->functions->adminOnly();

        $error = $msg = "";

        $categories = $this->functions->categoryTable->findAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $error = $this->functions->notEmptyCheck($_POST["name"], "A field was left blank!");
        }

        if ($error == "" && (isset($_POST['submit']))) {

            $values = [
                "name" => $_POST['name'],
            ];

            $this->functions->categoryTable->insert($values);
            header('location: /category/managecategory');
            $msg = 'The Category was successfully created!';
        }

        if (isset($_GET['remove'])) {

            $product = $this->functions->productTable->find('product_id', $_GET['remove']);
            $category = $this->functions->categoryTable->find('category_id', $product['category_id']);

            $this->functions->valueEmpty($category, '/category/managecategory');

            $msg = 'The Product ' . $product['name'] . ' was successfully removed from the ' . $category['name'] . ' category';

            $values = [
                'product_id' => $_GET['remove'],
                'category_id' => null
            ];

            $this->functions->productTable->update($values);
        }

        return [
            'title' => 'Manage Categories',
            'template' => 'managecategory',
            'variables' => [
                'error' => $error,
                'msg' => $msg,
                'productTable' => $this->functions->productTable,
                'categories' => $categories
            ]
        ];
    }

    public function home()
    {   

        return [
            'title' => 'Tech Store Products',
            'template' => 'home',
            'variables' => [
                'products' => $this->functions->productTable->findMostRecent('product_id', '10')
            ]
        ];
    }

    
    public function delete()
    {
        $this->functions->adminOnly();

        $category = $this->functions->categoryTable->find('category_id', $_GET['id']);
        $products = $this->functions->productTable->findMutiple('category_id', $category['category_id']);

        if (isset($_GET['id']) && !(empty($category))) {

            foreach ($products as $product) {

                $values = [
                    "product_id" => $product['product_id'],
                    "category_id" => null
                ];

                $this->functions->productTable->update($values);
            }

            $this->functions->categoryTable->delete('category_id', $_GET['id']);

            header("location: /category/deleted");
        } 
            
        return [
            'title' => 'Delete Category',
            'template' => 'message',
            'variables' => []
        ];
    }

    public function deleted() 
    {
        return [
            'title' => 'Category Deleted',
            'template' => 'message',
            'variables' => [
                'title' => 'Category Successfully Deleted',
                'message' => '<a href="/category/managecategory" >Return to Manage Category Page</a>'
            ]
        ];
    }

    public function NoCategoryFound()
    {   

        return [
            'title' => 'No Category Found',
            'template' => 'message',
            'variables' => [
                'title' => 'Products Category not found or either contains no products',
                'message' => '<a href="/category/home" >Return to Homepage</a>'
            ]
        ];
    }
}