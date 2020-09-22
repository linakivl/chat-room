$(document).ready(function(){

    var chatRoomId = $("#chat-window").data("chat-id");
    var lastMsgRoomId = 0;
    
    
    checkNewPrivateMsg();
    updateUserLoginStatus();
    displayNewMsgsRooms();

    $('#privateRoomBtn').click(function(e){

        e.preventDefault();
        var userText = $("#privateRoomMsg").val();
        resetInput();
        saveTextToDb(userText);

    });

    function saveTextToDb(userText){

        $.ajax({

            url: global_var.siteUrl + "room/savePrivateText",
            type: "post",
            data: {
                "userText": userText,
                "chatRoomId": chatRoomId
            },
            success: function(response){
               
                checkNewPrivateMsg();
            }
        });

    }


    function checkNewPrivateMsg(){
        
        $.ajax({
            url: global_var.siteUrl + "room/getPrivateMsgs",
            type: "post",
            dataType: 'json',
            data: {
                "chatUserId": chatRoomId,
                "lastMsgRoomId" : lastMsgRoomId
    
            },success(response){
               
                if (response.status) {
                    $(".chat-box_wrapper").append(response.messages);
                    lastMsgRoomId = response.lastId;
                    $('.chat-box_wrapper').scrollTop($('.chat-box_wrapper')[0].scrollHeight);
                } 
            }
        });
    }

    setInterval(function(){
        
        checkNewPrivateMsg();
        updateUserLoginStatus();
        displayNewMsgsRooms();
      
    }, 5000);

    function resetInput(){

        document.getElementById("roomInputForm").reset();
    }    

    function updateUserLoginStatus(){
        
        $.ajax({

            url: global_var.siteUrl + "chat/updateUsersTimeController",
            success: function(){}
        });
    }
    function displayNewMsgsRooms(){
        //  var chatUrl = window.location.pathname.split("/").pop();
        $.ajax({

            url: global_var.siteUrl + "room/newpendingMsgs",
            type: "post",
            dataType: "json",
            data: {
                "chatUrlId" : chatRoomId
            },
            success: function(data){
                if (data.status) {
                    console.log(data.rooms);
                    $(".chat-box-rooms").html(data.rooms);
                }
            }

        });

    }
   
});


   


