<div class="container-form">
    <form  method="POST">
        <input type="text" id="regName" name="userName" placeholder="Username" required> 
        <input type="text" id="regEmail" name="userEmail" placeholder="Email" required> 
        <input type="password" id="regPass" name="userPass" placeholder="Password" required>
        <!-- <a href="<?php echo WEBROOT .'chat/index'?>"> -->
            <input type="submit" id="userRegBtn" name="registerBtn" value="Register">
        <!-- </a> -->
        <p id="regError"></p>
    </form>
</div>