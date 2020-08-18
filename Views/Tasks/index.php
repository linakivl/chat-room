<form action="<?php echo WEBROOT . 'tasks/login'?>" method="POST">
    <input type="text" name="userName" placeholder="Email or Username" required> 
    <input type="text" name="userPass" placeholder="Password" required>
    <input type="submit" name="userLoginBtn" value="Login">
</form>

<?php echo $username; ?>