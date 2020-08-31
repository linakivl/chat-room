$(document).ready(function(){

    displayOnlineUsers();

    $("#logOutBtn").click(function(e){
        console.log("he");
        e.preventDefault();
    
        var offline = 0;
        $.ajax({
            
            url: "changeStatus",
            type: "post",
            data :{
                
                'userStatus' : offline
            }, 
            success : function(response){

                $.ajax({

                    url: "logoutUser",
                    success: function(response){
                        location.reload();
                    }
                });
            }

        });
    
    });

    function displayOnlineUsers(){
    
        $.ajax({

            url: "onlineUsersStatus",
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
       }, 5000);

////////////////////////////////////////////////////////////////////////////////////////////////////
///SE EPEKSERGASIA
    $('#mainchatBtn').click(function(){

        var userText = $("#mainchatText").val();
        var promiseSendChat = promiseSendChat(userText);
        console.log(promiseSendChat);
        // var promiseGetLinesChat = promiseGetLinesChat();
        // var promisechat1 = $.when(promiseSendChat,promiseGetLinesChat);
        // promisechat1.done(function(){

        });
        // $('#viewChatMessages').html(userText);

  


    //mia start function pou tha exei mesa thn getLines me to pou ksekinaei h efarmogh 
    function promiseSendChat(userText){

        return $.ajax({

            url: "sendLineToDb",
            type: "post",
            data: {
                'action': "sendLineToDb",
                "sendText": text
            }
            ,success(data){
                // console.log(data);
            }

        });

    } 

    function promiseGetLinesChat(data){
        var data = data;
        console.log(data);
        $.ajax({

            url: "getLinesFromDb",
            data :{
                "userId" : data
            },
            success(data){
                $("#viewChatMessages").html(data);
            }
        });

    }
});



