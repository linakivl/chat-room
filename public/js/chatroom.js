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
                    // console.log(response);
                    $('#activeUserBox').html("");
                }
            }

        });
    }
    setInterval(function(){
        displayOnlineUsers();
       }, 5000);

});



