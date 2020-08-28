
<h2>Hello <?php echo $_SESSION['username'];  echo $_SESSION['loginId'];?></h2>

<form action="<?php echo WEBROOT . 'authentication/logoutUser'?>" method="POST">
   
    <input type="submit" name="userLogout" value="Logout">
    <div class="activeUserBox"></div>

</form>
