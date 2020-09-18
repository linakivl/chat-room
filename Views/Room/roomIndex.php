<h3 class="chat-window-username"><?php foreach ($username as $key) { echo $key['userName'];}?></h3>
<div id="chat-window"  class="container-chat_box_window " data-chat-id="<?php echo $chatId; ?>">
    <div class="chat-box">
        <div class="chat-box_wrapper" style="height: 700px; overflow-y: scroll;
        overflow-x: hidden; padding: .5rem;">
              <!--display chat messages   -->
        </div>
      <div class="chat-box-input">
        <form id="roomInputForm">
          <input type="text" id="privateRoomMsg" name="privateRoomMsg " autocomplete="off">
          <input type="submit" id="privateRoomBtn" name="privateRoomBtn">
        </form>
        
      </div> 
  </div>
  <div class="chat-box-rooms">hhhhhh</div>
</div>