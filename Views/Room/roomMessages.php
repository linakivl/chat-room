
<div class="chat-box-messages" >
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

