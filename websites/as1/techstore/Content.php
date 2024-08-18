<?php

namespace techstore;

class Content 
{   

    public function fetchData()
    {
        require '../database.php';

        $categoryTable = new \Framework\DatabaseTable($pdo, 'category', 'category_id');
        $productTable = new \Framework\DatabaseTable($pdo, 'products', 'product_id');
        
        $categories = $categoryTable->findAll();
        $products = $productTable->findMostRecent('product_id', '3');

        $product_list = [];
        $product_desc_list = [];
        $product_id_list = [];

        foreach ($products as $product) {
            $product_list[] = $product['name'];
            $product_id_list[] = $product['product_id'];
            $product_desc_list[] = $product['description'];
        }

        $contents = [
            'categories' => $categories,
            'P1' => $product_list[0],
            'P1_id' => $product_id_list[0],
            'D1' => $product_desc_list[0],
            'P2' => $product_list[1],
            'P2_id' => $product_id_list[1],
            'D2' => $product_desc_list[1]
        ];

        return $contents;
    }

}