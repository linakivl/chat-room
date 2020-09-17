$(document).ready(function(){
    var lastMsgId = null;
    var chatId = $('#chat-window').data('chat-id');
    var lastMsgRoomId = null; 

    displayOnlineUsers();  
    checkForNewMsg();

 
    $("#logOutBtn").click(function(e){
        console.log("he");
        e.preventDefault();
    
        var offline = 0;
        $.ajax({
            
            url: global_var.siteUrl + "chat/changeStatus",
            type: "post",
            data :{
                
                'userStatus' : offline
            }, 
            success : function(response){

                $.ajax({

                    url:  global_var.siteUrl + "chat/logoutUser",
                    success: function(response){
                        location.reload();
                    }
                });
            }

        });
    
    });
   
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
      
       }, 5000);

   

    $('#mainchatBtn').click(function(e){
        e.preventDefault();
        var userText = $("#mainchatText").val();
        resetForm();
        saveData(userText).done(function(data){
        if(data > 0){
            // showData(data);
        }
        });
    });

    function saveData(text){
         
       
          return $.ajax({

            url: global_var.siteUrl + "chat/sendLineToDb",
            type: "post",
            data: {

                "action" : "sendLineToDb",
                "sendText" : text
            },
            success: function(response){
                checkForNewMsg();              
            }
        });
    }

      function displayMessages(){
          if(Number.isInteger(chatId)){

            checkNewPrivateMsg(chatId);

          }else{
            checkForNewMsg();     
          }
      }

      function checkNewPrivateMsg(chatId){
            console.log(lastMsgRoomId);
            $.ajax({
                url: global_var.siteUrl + "chat/getPrivateMsgs",
                type: "post",
                dataType: 'json',
                data: {
                    "chatUserId": chatId,
                    "lastMsgRoomId" : lastMsgRoomId

                },success(response){
                    if (response.status) {
                
                    $(".chat-box").append(response.msgs);
                    lastMsgId = response.lastId
                    $('#container-chatMessages_box').scrollTop($('#container-chatMessages_box')[0].scrollHeight);
                    } 
                 
                }
            });
      }

   

    $('body').on('click', '.online-user', function(e){

        var userId = $(e.currentTarget).data('tasks-id');
        chatId = userId;
        console.log(chatId);
        $.ajax({

            url : global_var.siteUrl + "chat/redirectToChat",
            type: "post",
            data: {

                "userChatId": chatId

            },success: function(response){
                
            //    location.reload();
            }   

        });
    });


    function resetForm(){

        document.getElementById("inputText").reset();

    }
});


