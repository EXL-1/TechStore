<?php

?>
<h1><?= $product['name'] ?></h1>

<p>Brand: <?= $product['manufacturer'] ?></p>
<hr />
<br>

<ul class="products">
    <li>
        <img src="<?= $product['product_picture_img'] ?>" alt="product-img" />
        <p><?= $product['description'] ?></p>
        <br>
        <br>
    </li>
</ul>
<br>
<hr />
<br>
<? if (isset($_SESSION['loggedin']) && $_SESSION['account_type'] == 'customer') { ?>
    <h2>Submit a question</h2>
    <form action="" method="post">
        <br>
        <input type="text" name="question" placeholder="Your Question..." />
        <input type="submit" name="submit" value="submit" />
        <p class="error"><?=$error ?? ''?><p>
        <p class="success"><?=$msg ?? ''?><p>
    </form>
    <br>
    <hr>
<? } ?>

<h4>Product Questions</h4>

<ul class="reviews">

    <?= $noquestions ?? ''?>

    <? foreach ($questions as $question) { ?>
        <? if ($question['status'] == 'verified' && $question['visibility'] == 'yes') { ?>
            <li>
                <h3><?= $question['question'] ?></h3>
                <p><?=$question['answer']?></p>
                <div class="details">
                    <? $customer = $customerTable->find('customer_id', $question['customer_id']) ?>
                    <? $admin = $adminTable->find('admin_id', $question['admin_id']) ?>
                
                    <em>Date Posted: <?=$question['date_posted']?></em><br>
                    <em>Submitted By: <strong> <?=$customer['firstname'] . ' '.$customer['surname']?></strong></em><br>
                    <em>Answered By: <strong> <?=$admin['firstname'] . ' '. $admin['surname']?></strong></em>
                </div>
            </li>
   <? } }?>
</ul>