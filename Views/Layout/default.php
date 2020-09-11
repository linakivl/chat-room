<?php
    include APPROOT . "/Views/Includes/header.php";
   
?>


<main role="main" class="login-container">

    <div class="middle-up">

        <?php
        echo $content_for_layout;
        ?>

    </div>
    <svg id="stroke" viewBox="0 0 500 50" preserveAspectRatio="xMinYMin meet">
        <path d="M0,50 L0,4 C95,-23 285,115 500,2 L500,50 L0,50 Z" 
            style="stroke: none;/*  */">
        </path>
    </svg>
</main>

<?php
     include APPROOT . "/Views/Includes/footer.php";
?>