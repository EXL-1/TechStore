<? if ($signin == 'customer') { ?>
    <h1>Sign In</h1>
<? } else { ?>
    <h1>Admin Sign In</h1>
<? } ?>
<hr />

<form action="" method="post">
    <label>Email</label> <input type="text" name="email" placeholder="Your Email..." />
    <label>Password</label> <input type="password" name="password" placeholder="Your Password..." />

    <input type="submit" name="submit" value="submit" />

    <p class="error"><?= $loginErr ?><p>
</form>

<? if ($signin == 'customer') { ?>
    <a href="/customer/register">
        <h2>Don't have an account? Create one now!</h2>
    </a>
<? } ?>