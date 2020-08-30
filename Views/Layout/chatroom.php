<?php
    include APPROOT . "/Views/Includes/header.php";
   
?>
<main role="main" class="container">

    <div class="starter-template">

        <?php
        echo $content_for_layout;
        ?>

    </div>

</main>
<?php
     include APPROOT . "/Views/Includes/chatfooter.php";
?>