<?php
    include APPROOT . "/Views/Includes/header.php";
   
?>
<main  class="container-chat">

    <div class="container-chat_box" id="private-room">
        
        <?php
        echo $content_for_layout;
        ?>

    </div>

</main>
<?php
     include APPROOT . "/Views/Includes/roomfooter.php";
?>