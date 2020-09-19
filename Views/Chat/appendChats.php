<div class="window-sidebar-right_headline">
    <h3>New Messages(<?php echo count($users) ?>)</h3>
</div>
<div class="newMessagesBox">
    <ul>
        <?php foreach($users as $id => $username){ ?>
            <li class="online-user"><a href="<?php echo WEBROOT . 'room/privateChat/' .$id;  ?>" data-tasks-id='<?php echo $id; ?>'">
                <?php echo $username; ?></a>  
            </li>
        <?php } ?>
    </ul> 
</div>