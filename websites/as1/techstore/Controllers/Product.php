<?php

namespace techstore\Controllers;
class Product
{
    private $functions;
    public function __construct($functions)
    {
        $this->functions = $functions;
    }

    public function product()
    {
        $error = $msg = '';

        $this->functions->notFound('/product/noproductfound');

        if (isset($_GET['id'])) {
           $product = $this->functions->productTable->find('product_id', $_GET['id']);
           $questions = $this->functions->questionTable->findMutiple('product_id', $_GET['id']);      
        } 

        $this->functions->valueEmpty($product, '/product/noproductfound');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $error = $this->functions->notEmptyCheck($_POST["question"], "Question cannot be blank!");
        }
         
        if ($error == '' && (($_POST['submit'])?? '')) {

            $customer = $this->functions->customerTable->find('email', $_SESSION['email'] ?? '');
            
            $values = [
                'customer_id' => $customer['customer_id'],
                'product_id' => $_GET['id'],
                'question' => $_POST['question']
            ];

            $this->functions->questionTable->insert($values);

            $msg = "Your question was successfully submitted!";
        }

        return [
            'title' => 'Product',
            'template' => 'productpage',
            'variables' => [
                'product' => $product,
                'questions' => $questions,
                'error' => $error,
                'msg' => $msg,
                'noquestions' => $this->functions->notEmptyCheck($questions, "This Product has no Questions"),
                'customerTable' => $this->functions->customerTable,
                'adminTable' => $this->functions->adminTable,
            ]
        ];
    }
    public function manageproduct()
    {

        $this->functions->adminOnly();

        $error = $msg = "";

        if (isset($_POST['submit'])) {

            $values = [
                "product_id" => $_POST['productselection'],
                "category_id" => $_POST['category'],
            ];

            $this->functions->productTable->update($values);
            $category = $this->functions->categoryTable->find('category_id', $_POST['category']);
            $msg = 'The Product was successfully added to the category of ' . $category['name'];
        }

        if (isset($_POST['add'])) {
            if (isset($_FILES["image"])) {
                $target_dir = "../public/uploaded-images/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (
                    (file_exists($target_file)) || ($_FILES["image"]["size"] > 500000) ||
                    ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
                ) {
                    $error = "Product Image is either invalid, already exists or is too large!";
                }

                if (empty($_POST["name"]) || empty($_POST["manufacturer"]) || empty($_POST["price"]) || empty($_POST["description"])) {
                    $error = "One or more fields were left blank!";
                }

                if (!(preg_match('/^\d+\.\d+$/', $_POST["price"]))) {
                    $error = "Price must be an integer with a decimal!";
                }
            }

            if ($error == "" && (isset($_POST['add']))) {

                $values = [
                    "name" => $_POST['name'],
                    "manufacturer" => $_POST['manufacturer'],
                    "price" => $_POST['price'],
                    "description" => $_POST['description'],
                    "product_picture_img" => '../uploaded-images/' . basename($_FILES["image"]["name"])
                ];

                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $this->functions->productTable->insert($values);

                $msg = 'The Product was successfully created!';
            }
        }

        if (isset($_GET['allproducts'])) {
            $products = $this->functions->productTable->findAll();
        } else {
            $products = $this->functions->productTable->findMostRecent('product_id', '5');
        }

        return [
            'title' => 'Manage Products',
            'template' => 'manageproduct',
            'variables' => [
                'error' => $error,
                'msg' => $msg,
                'recent_products' => $products,
                'categories' => $this->functions->categoryTable->findall()
            ]
        ];
    }

    public function delete()
    {
        $this->functions->adminOnly();

        $product = $this->functions->productTable->find('product_id', $_GET['id']);
        $questions = $this->functions->questionTable->findMutiple('product_id', $_GET['id']);

        if (isset($_GET['id']) && !(empty($product))) {

            unlink('../public' . substr($product['product_picture_img'], 2));

            foreach ($questions as $question) {
                $this->functions->questionTable->delete('product_id', $question['product_id']);
            }

            $this->functions->productTable->delete('product_id', $_GET['id']);

            header("location: /product/deleted");
        } 
            
        return [
            'title' => 'Delete Product',
            'template' => 'message',
            'variables' => []
        ];
    }

    public function deleted() 
    {
        return [
            'title' => 'Deleted',
            'template' => 'message',
            'variables' => [
                'title' => 'Product Successfully Deleted',
                'message' => '<a href="/product/manageproduct" >Return to Manage Products Page</a>'
            ]
        ];
    }

    public function NoProductFound()
    {   

        return [
            'title' => 'No Product Found',
            'template' => 'message',
            'variables' => [
                'title' => 'Product Not Found',
                'message' => '<a href="/category/home" >Return to Homepage</a>'
            ]
        ];
    }
}