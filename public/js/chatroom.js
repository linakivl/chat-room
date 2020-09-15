$(document).ready(function(){
    var lastMsgId = null;
    var chatId = $('#chat-window').data('chat-id');
    var newMsg = null;

    displayOnlineUsers();  
    displayMessages();
    timeout();

 
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
        
        if(lastMsgId){
            $.ajax({
                url: global_var.siteUrl + "chat/checkNewMsg",
                type: "post",
                data: {
                    "lastMessageId" : lastMsgId
                },
                success: function(response){
                    console.log(response);
                    if (response) {
                    
                        $(".chatMessages").append(response);
                        newMsg = response;
                    } 
                }
            });
        }
    }

    function timeout(){
    //    if(newMsg){
         
    //     $.ajax({
    //         url: global_var.siteUrl + "chat/checkNewMsg",
    //         type: "post",
    //         data: {
    //             "lastMessageId" : lastMsgId
    //         },
    //         success: function(response){
    //             console.log(response);
    //             $(".newMsg").html(response);
    //         }
    //    });
    // }
    
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
        timeout();
      
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
                lastMsgId = response;
                checkForNewMsg();
              
            }
        });
    }

      function displayMessages(){
          if(Number.isInteger(chatId)){

            displayPrivateMsgs(chatId);

          }else{

            displayPublicMsgs();
          }
      }

      function displayPublicMsgs(){

           $.ajax({
            
            url: global_var.siteUrl + "chat/getAllPublicMessages",
            success(response){
                //this line of code force the user to not scroll up/ 
                $('#container-chatMessages_box').html(response);
                $('#container-chatMessages_box').scrollTop($('#container-chatMessages_box')[0].scrollHeight);
            }
          });
      }
      function displayPrivateMsgs(chatId){

           
            console.log(chatId);
            $.ajax({
                url: global_var.siteUrl + "chat/getAllRoomMessages",
                type: "post",
                data: {
                    "chaUserId": chatId
                },success(response){
                   $(".chat-box").html(response);
                }
            });

      }

      function resetForm(){
      
        document.getElementById("inputText").reset();
    }

    $('body').on('click', '.online-user', function(e){

        var userId = $(e.currentTarget).data('tasks-id');
        chatId = userId;
      
        $.ajax({

            url : global_var.siteUrl + "chat/room",
            type: "post",
            data: {
                "userChatId": userId
            },success(response){
                
                $('.container-chat_box').html(response);
                displayPrivateMsgs(chatId);
            }   

        });
    });
});


