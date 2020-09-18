<div class="container-form">
    <form  method="POST">
        <input type="text" id="logEmail" name="userEmail" placeholder="Email" required> 
        <input type="password" id="logPass" name="userPass" placeholder="Password" required>
        <input type="submit"  id="userLoginBtn" name="userLoginBtn" value="Submit">
        <p id="logError"></p>
        <div class="setUsernameBox" style="display:none">Set your username: 
            <input type="text" id="usernameInput">
            <a href="<?php echo WEBROOT . 'chat/index'?> ">
            <input type="submit" id="setUsernameBtn" value="Login"></a>
            <p id="usernameError"></p>
        </div>
        <a href="<?php echo WEBROOT . 'authentication/register'?>">Register</a>
    </form>
</div>

