<form action="<?php echo WEBROOT . 'authentication/login_check'?>" method="POST">
    <input type="text" name="userEmail" placeholder="Email" required> 
    <input type="text" name="userPass" placeholder="Password" required>
    <input type="submit" name="userLoginBtn" value="Login">
</form>