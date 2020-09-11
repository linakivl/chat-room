<div class="window-sidebar-right_headline">
    <h3>Members Online(<?php echo count($onlineUsers) ?>)</h3>
</div>
<ul>
    <?php foreach($onlineUsers as $row){ ?>
        <li data-tasks-id='<?php echo $row['userId'] ?>' class="online-user"> <?php echo $row['userName'] ?> </li>
    <?php } ?>
</ul>