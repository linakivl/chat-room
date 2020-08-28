$(document).ready(function(){
  
    $("#userLoginBtn").click(function(e){
        event.preventDefault();
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
                    $.ajax({

                        url: "chatIndex",
                        type: 'post',
                        data: {
                            'action': 'redirect',
                        }, success: function(data){
                            location.reload();
                        }
                });
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
            success : function(data){

                $('#regError').html(data);
               
                if($.isNumeric(data)){
                    $('#regError').html("");
                    $.ajax({

                        url: "chatIndex",
                        type: 'post',
                        data: {
                          'action': 'redirect',
                        }, success: function(data){
                            location.reload();
                        }
                });
              }
             
            }
        });
    });

});