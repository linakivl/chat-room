<?php?>
<form action="<?php echo WEBROOT . 'authentication/login_check'?>" method="POST">
    <input type="text" name="userEmail" placeholder="Email" required> 
    <input type="password" name="userPass" placeholder="Password" required>
    <input type="submit" name="userLoginBtn" value="Login">
    <p><?php echo !empty($errorMsg)? $errorMsg : ''; ?></p>
    
    <a href="<?php echo WEBROOT . 'authentication/registerUser'?>">Register</a>
</form>
</br>

