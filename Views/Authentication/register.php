<form action="<?php echo WEBROOT . 'authentication/registerUser'?>" method="POST">
    <input type="text" name="userName" placeholder="Username" required> 
    <input type="text" name="userEmail" placeholder="Email" required> 
    <input type="password" name="userPass" placeholder="Password" required>
    <input type="submit" name="registerBtn" value="Login">
</form>