<h1>Questions</h1>
<? if ($_SESSION['account_type'] == 'admin') {

    if ($_GET['unanswered'] ?? '') { ?>
        <h4>Unanswered Questions</h4>
        <a href="/question/admin">
            <p>See all questions</p>
            <p class="success"><?=$msg ?? ''?><p>
        </a>
    <? } else { ?>
        <h4>All Questions</h4>
        <a href="/question/admin?unanswered=true">
            <p>Filter to see all unanswered questions</p>
            <p class="success"><?=$msg ?? ''?><p>
        </a>
    <? } ?>
<? } else { ?>
    <h4>Your Product Questions</h4>
<? } ?>

<hr />
<br>
<ul class="reviews">

    <?= $noquestions ?? '' ?>

    <? foreach ($questions as $question) { ?>
        <? $product = $productTable->find('product_id', $question['product_id']) ?>
        <li>
            <h3><?= $question['question'] ?></h3>
            <p>Product: <?= $product['name'] ?></p><br>

            <? if ($_SESSION['account_type'] == 'admin' && $question['status'] == 'pending') { ?>
                <form action="" method="post">
                    <br>
                    <input type="hidden" name="question_id" value="<?=$question['question_id']?>" />
                    <select name="visibility" id="visibility">
                        <option selected="selected" value="yes">Yes, Show this question</option>
                        <option value="no">No, Don't show this question</option>
                </select>
                    <input type="text" name="answer" placeholder="Your Answer..." />
                    <input type="submit" name="submit" value="submit" />
                    <p class="error"><?= $error ?? '' ?>
                    <p>
                    <p>
                </form>
            <? } else { ?>
                <p>Response: <?= $question['answer'] ?></p>
            <? } ?>
            <div class="details">

                <em>Status: <?= $question['status'] ?></em><br>

                <? if ($_SESSION['account_type'] == 'admin') {
                    $customer = $customerTable->find('customer_id', $question['customer_id']) ?>
                    <em>Visibility: <?= $question['visibility']?></em><br>
                    <em>Submitted By: <?= $customer['firstname'] . ' ' . $customer['surname'] ?></em><br>
                <? } ?>
                <em>Date Submitted: <?= $question['date_posted'] ?></em><br>
                <?
                if ($question['status'] == 'verified' && $question['admin_id'] ?? '') {
                    $admin = $adminTable->find('admin_id', $question['admin_id']) ?>
                    <strong><em>Answered By: <?= $admin['firstname'] . ' ' . $admin['surname'] ?></em></strong>
                <? } ?>

            </div>
        </li>
    <?  } ?>
</ul>