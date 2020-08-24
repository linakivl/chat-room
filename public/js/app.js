$(document).ready(function(){
  
    $("#userLoginBtn").click(function(){
        event.preventDefault();
        var logEmail = $("#logEmail").val();
        var logPass = $("#logPass").val();

        $.ajax({

            url: "login_check",
            type: 'post',
            data: {
                'action': 'login-task',
                'userEmail': logEmail,
                'userPass': logPass
            },
            success: function(response){
                if(response.length <=  100){
                    
                    $('#logError').html(response);
                }
                else{
                    location.reload();
                }
            }
          
        });
    });

    $("#userRegBtn").click(function(){
        event.preventDefault();
        var regName = $("#regName").val();
        var regEmail = $("#regEmail").val();
        var regPass = $("#regPass").val();
        
        $.ajax({

            url : "registerUser",
            type : 'post',
            data : {

                'action' : 'register-task',
                'userName' : regName,
                'userEmail' : regEmail,
                'userPass' : regPass
            },
            success : function(response){
                console.log(response.length);
                if(response.length < 100){
                    
                    $('#regError').html(response);
                }
                else{
                    location.reload();
                }
             
            }
        });
    });

});