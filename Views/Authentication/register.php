<!-- <form action="<?php echo WEBROOT . 'authentication/registerUser'?>" method="POST">
    <input type="text" name="userName" placeholder="Username" required> 
    <input type="text" name="userEmail" placeholder="Email" required> 
    <input type="password" name="userPass" placeholder="Password" required>
    <input type="submit" name="registerBtn" value="Register">
    <p><?php 
        if(!empty($errorMsg)){
             foreach($errorMsg as $k=> $item1){
                 if($item1[1] === "reg")
                 {
                    echo $item1[0];  
                 }
                   else{
                       echo "";
                   }
            } 
        
        }
    
       ?></p>
</form> -->
<form action="<?php echo WEBROOT . 'authentication/registerUser'?>" method="POST">
    <input type="text" name="userName" placeholder="Username" required> 
    <input type="text" name="userEmail" placeholder="Email" required> 
    <input type="password" name="userPass" placeholder="Password" required>
    <input type="submit" name="registerBtn" value="Register">
    <p><?php echo !empty($errorMsg)? $errorMsg : ''; ?></p>
</form>