<? if ($page ?? '' == 'products') { ?>
    <h1><?= $category['name'] ?></h1>
    <p>A Number of <?= $products_count ?> products were found</p>
<? } else { ?>
    <h1>Welcome to Ed's Electronics</h1>
    <p>We stock a large variety of electrical goods including phones, tvs, computers and games. Everything comes with at least a one year guarantee and free next day delivery.</p>
<? } ?>

<hr />
    <br>
    <h2>Products list</h2>
<ul class="products">

    <? foreach ($products as $product) { ?>
        <li>
        <a href="/product/product?id=<?=$product['product_id']?>">
            <img src="<?= $product['product_picture_img'] ?>" alt="product-img" />
           <h3><?= $product['name'] ?></h3></a>
            <p><?= $product['description'] ?></p>
            <div class="price">£<?= $product['price'] ?></div>
        </li><? } ?>
</ul>

