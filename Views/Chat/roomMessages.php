<h3 class="chat-box_name"><?php foreach($username as $val){
    echo $val['userName'];
} ?></h3>
<ul>
    <?php foreach ($usersAllMessages as $key) : ?>
        <?php echo $key["fromUserId"] !== $_SESSION["id"] ? "<li class='other-user'>" : "<li class='current-user'>"  ?>
        <div class="text-field">
            <p><?php echo $key["privateText"]?></p>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
<div class="chat-box-input">
    <form action="">
        <input type="text" name="privateMsg">
        <input type="submit" name="privateBtn">
    </form>
</div>