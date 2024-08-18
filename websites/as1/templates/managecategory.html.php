<h1>Manage Categories</h1>

<p class="success"><?= $msg ?? '' ?>
<p>
    <hr />
    <br>
<h2>All categories:</h2>

<form action="" method="post">
    <ul class="products">
        <? foreach ($categories as $category) { ?>
            <li>    
            <a href="/category/product?id=<?=$category['category_id']?>"><h3><?=$category['name']?></h3></a>
                <? $products = $productTable->findMutiple('category_id', $category['category_id']) ?>
                <br>
                <? foreach ($products as $product) { ?>
                    <a href="/product/product?id=<?=$product['product_id']?>"><p><?=$product['name']?></a>
                    <a class="error" href="/category/managecategory?remove=<?= $product['product_id'] ?>"> &nbsp;&nbsp; Remove</a>
                </p>
                <? } ?>
                <br>
                <a class="error" href="/category/delete?id=<?= $category['category_id'] ?>">Delete</a>
            </li>
        <? } ?>
        <br>
</form>

<br>
<hr />
<br>

<h2>Add a category</h2>
<form action="" method="post">
    <label>Category Name</label> <input type="text" name="name" />
    <input type="submit" name="submit" value="Add Category" />
    <p class="error"><?= $error ?? '' ?>
    <p>
</form>