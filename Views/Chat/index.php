
<h2>Hello <?php echo $_SESSION['username'];?></h2>

<form action="<?php echo WEBROOT . 'chat/logoutUser'?>" method="POST">
   
    <input type="submit" name="userLogout" value="Logout">


</form>
