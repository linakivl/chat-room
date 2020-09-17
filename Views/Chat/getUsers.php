<div class="window-sidebar-right_headline">
    <h3>Members Online(<?php echo count($onlineUsers) ?>)</h3>
</div>
<ul>
    <?php foreach($onlineUsers as $row){ ?>
        <li class="online-user"><a href="<?php echo WEBROOT . 'room/privateChat/' .$row['userId'];  ?>" data-tasks-id='<?php echo $row['userId'] ?>'">
            <?php echo $row['userName'] ?></a>  
        </li>
    <?php } ?>
</ul> 