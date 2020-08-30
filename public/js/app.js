$(document).ready(function(){
   
  

    $("#userLoginBtn").click(function(e){
        e.preventDefault();
        var logEmail = $("#logEmail").val();
        var logPass = $("#logPass").val();
    
        $.ajax({

            url: "login_check",
            type: 'post',
            dataType: "json",
            data: {
                'action': 'login-task',
                'userEmail': logEmail,
                'userPass': logPass
            },
            success: function(data){

                $('#logError').html(data);
               
                if($.isNumeric(data)){
                    $('#logError').html("");
                    
                    $(".setUsernameBox").slideDown();
                   
              }
            }
        });
    });

    $("#setUsernameBtn").click(function(e){
        e.preventDefault();
        var username = $("#usernameInput").val();
        var check = checkUsername(username);
       
        if(check === true){
            
             $.when(

                $.ajax({

                    url: "usernameCheck",
                    type: "post",
                    dataType: "json",
                    data: {
                        "newUsername": username
                    }, success: function(data){
                        console.log(data);
                        // $("#logError").html(data);
                    }
                })

            ).then(redirectToMain());
              
        }
    });

    function checkUsername(username){
    
        if(username.length <= 4 || username.value === "" || /[^A-Za-z\d]/.test(username)){
            
            document.getElementById("usernameError").innerHTML = "Your username must contain at least 4 characters";
            return false;
        }
        document.getElementById("usernameError").innerHTML = "";
         return true;   
     
    }
    function redirectToMain(){

        $.ajax({

            url: "redirectToChat",
             success: function(data){
                location.reload();
            }
        });
    }

    $("#userRegBtn").click(function(e){
        e.preventDefault();
       
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
            success : function(data){

                $('#regError').html(data);
               
                if($.isNumeric(data)){
                    $('#regError').html("");
                    $.ajax({

                        url: "redirectToChat",
                         success: function(data){
                            location.reload();
                        }
                });
              }
             
            }
        });
    });

});


