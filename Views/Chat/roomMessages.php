<div class="chat-box-messages">
    <!-- <div class="chat-box-username">
        <h3 class="chat-box_name"><?php foreach($username as $val){
            echo $val['userName'];
        } ?></h3>
    </div> -->
    <div class="chat-box-text">
        <ul>
            <?php foreach ($lastPrivateMessage as $key) : ?>
                <?php echo $key["fromUserId"] !== $_SESSION["id"] ? "<li class='other-user'>" : "<li class='current-user'>"  ?>
                <div class="text-field">
                    <p><?php echo $key["privateText"]?></p>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
