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
    $('#mainchatBtn').click(function(e){
        e.preventDefault();
        var userText = $("#mainchatText").val();
      
        saveData(userText).done(function(data){
        if(data > 0){

            showData(data);

        }
          
        });
     

    });
    function saveData(text){
       
          return $.ajax({

            url: "sendLineToDb",
            type: "post",
            data: {

                "action" : "sendLineToDb",
                "sendText" : text
            }

        });

    }

    function showData(userid){

          $.ajax({

            url: "getLinesFromDb",
            type: "post",
            data: {

                "userId" : userid
            },success: function(data){

                $('#viewChatMessages').html(data);
                
            }

        });
  
      }
    
});



