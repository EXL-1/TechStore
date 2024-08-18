
<? if ($type == 'admin') { ?>
<h1>Create a new admin account</h1>
<? } else { ?>
<h1>Create a new account</h1>
<? } ?>
<hr />

<form action="" method="post">
    <label>First Name</label> <input type="text" name="firstname" placeholder="Your First Name..."/>
    <label>Surname</label> <input type="text" name="surname" placeholder="Your Surname..."/>
    <label>Email</label> <input type="text" name="email" placeholder="Your Email..."/>
    <label>Password</label> <input type="password" name="password" placeholder="Your Password..."/>

    <input type="submit" name="submit" value="submit" />

    <p class="error"><?=$error?><p>
</form>

<? if ($type == 'customer') { ?>
<a href="/customer/login"><h2>Already have an account? Sign in now!</h2></a>
<? } ?>