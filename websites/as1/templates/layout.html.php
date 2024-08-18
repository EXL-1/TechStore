<!doctype html>
<html>

<head>
    <title><?= $title ?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../CSS-Files/electronics.css" />
</head>

<body>
    <header>
        <h1>Ed's Electronics</h1>


        <ul>
            <li><a href="/category/home">Home</a></li>
            <li>Products
                <ul>
                    <? foreach ($contents['categories'] as $category) { ?>

                        <li><a href="/category/category?id=<?= $category['category_id'] ?>"><?= $category['name'] ?></a></li>
                    <? } ?>
                </ul>
            </li>

            <li>Options
                <ul>
                    <? if (isset($_SESSION['loggedin'])) { ?>
                        <? if ($_SESSION['account_type'] == 'admin') { ?>
                            <li><a href="/question/admin">Questions</a></li>
                            <li><a href="/admin/create">Manage Admins</a></li>
                            <li><a href="/product/manageproduct">Manage Products</a></li>
                            <li><a href="/category/managecategory">Manage Categories</a></li>
                        <? } else { ?>
                            <li><a href="/question/customer">Questions</a></li>
                        <? } ?>
                        <li><a href="/customer/signout">Sign Out</a></li>

                    <? } else { ?>
                        <li><a href="/customer/login">Sign in</a></li>
                        <li><a href="/customer/register">Create Account</a></li>
                        <li><a href="/admin/login">Admin</a></li>
                    <? } ?>
                </ul>
            </li>
        </ul>

        <address>
            <p>We are open 9-5, 7 days a week. Call us on
                <strong>01604 11111</strong>
            </p>
        </address>



    </header>
    <section></section>

    <main>
        <?= $output ?>
    </main>

    <aside>

        <h1><a href="/product/product?id=<?=$contents['P1_id']?>">Featured Product</a></h1>
        <p><strong><?=$contents['P1']?></strong></p>
        <p><?=$contents['D1']?></p>
        <br>
        <h1><a href="/product/product?id=<?=$contents['P2_id']?>">Product of the Day</a></h1>
        <p><strong><?=$contents['P2']?></strong></p>
        <p><?=$contents['D2']?></p>

    </aside>

    <footer>
        &copy; Ed's Electronics 2023
    </footer>

</body>

</html>