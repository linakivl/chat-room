<div id="chat-window" class="container-chat_box_window" data-chat-id="<?php echo $chatId; ?>">
  
        <div class="window-header">
            <h1>Hello <?php echo $_SESSION['username'];  ?></h1>
            <a href="<?php echo WEBROOT . 'authentication/login'?>"><input type="submit" id="logOutBtn" name="userLogout" value="Logout"></a>
        </div>
    
        <div class="window-mainchat">
        
            
                <div id="container-chatMessages">
                    <div id="container-chatMessages_box"></div>
                    <form id="inputText">
                        <input type="text" id="mainchatText"  placeholder="Say something.." autocomplete="off">
                        <input type="submit" id="mainchatBtn" value="send">
                    </form>
                </div>
            
            <div class="window-sidebar-right">
                <div id="activeUserBox" class="window-sidebar-right_users"></div>
                <div id="newMessagesBox" class="window-sidebar-right_chats"></div>
            </div>
        </div>
    
    </div>
