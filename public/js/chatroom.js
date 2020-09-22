$(document).ready(function(){
    var lastMsgId = null;
    var chatId = $('#chat-window').data('chat-id');

    displayOnlineUsers();  
    checkForNewMsg();
    displayUnopenedChats();

 
  
    function checkForNewMsg(){        
        $.ajax({
            url: global_var.siteUrl + "chat/checkNewMsg",
            type: "post",
            dataType: 'json',
            data: {
                "lastMessageId" : lastMsgId
            },
            success: function(response){
                if (response.status) {

                    console.log(response);
                
                    $("#container-chatMessages_box").append(response.msgs);
                    lastMsgId = response.lastId
                    $('#container-chatMessages_box').scrollTop($('#container-chatMessages_box')[0].scrollHeight);
                } 
            }
        });
    }


    function displayOnlineUsers(){
    
        $.ajax({

            url: global_var.siteUrl + "chat/onlineUsersStatus",
            success: function(response){

                $('#activeUserBox').html(response);
                if(response == false){
                    $('#activeUserBox').html("");
                }
            }

        });
    }
    setInterval(function(){
        displayOnlineUsers();
        checkForNewMsg();
        displayUnopenedChats();
        updateUserLoginStatus();
       }, 5000);

   

    $('#mainchatBtn').click(function(e){
        e.preventDefault();
        var userText = $("#mainchatText").val();
        resetForm();
        saveData(userText);
    });

    function saveData(text){
         
          $.ajax({

            url: global_var.siteUrl + "chat/sendLineToDb",
            type: "post",
            data: {

                "sendText" : text
            },
            success: function(response){
                checkForNewMsg();              
            }
        });
    }
    function displayUnopenedChats(){

        $.ajax({

            url: global_var.siteUrl + "chat/unOpenedChatsController",
            dataType: "json",
            success: function(data){
                if (data.status) {

                    console.log(data.chats);
                
                    $("#newMessagesBox").html(data.chats);
                }
            }

        });

    }
    function updateUserLoginStatus(){
        
        $.ajax({

            url: global_var.siteUrl + "chat/updateUsersTimeController",
            success: function(){
            }
        });
    }

    function resetForm(){

        document.getElementById("inputText").reset();

    }
    $("#logOutBtn").click(function(e){
        // console.log("he");
        // e.preventDefault();
    
        // var offline = 0;
        // $.ajax({
            
        //     url: global_var.siteUrl + "chat/changeStatus",
        //     type: "post",
        //     data :{
                
        //         'userStatus' : offline
        //     }, 
        //     success : function(response){

                $.ajax({

                    url:  global_var.siteUrl + "chat/logoutUser",
                    success: function(response){
                        location.reload();
                    }
                });
            // }

        // });
    
    });
   

});


