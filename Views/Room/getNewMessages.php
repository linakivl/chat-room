<div class="window-sidebar-right_headline">
    <h3>New Rooms(<?php echo count($userRoom) ?>)</h3>
</div>
<div class="new-user-rooms">
    <ul>
        <?php foreach($userRoom as $id => $username){ ?>
            <li class="online-user"><a href="<?php echo WEBROOT . 'room/privateChat/' .$id;  ?>" data-tasks-id='<?php echo $id; ?>'">
                <?php echo $username; ?></a>  
            </li>
        <?php } ?>
    </ul> 
</div>
