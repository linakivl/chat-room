"use strict";

$(document).ready(function () {
  $("#userLoginBtn").click(function (e) {
    e.preventDefault();
    var logEmail = $("#logEmail").val();
    var logPass = $("#logPass").val();
    $.ajax({
      url: "login_check",
      type: 'post',
      dataType: "json",
      data: {
        'userEmail': logEmail,
        'userPass': logPass
      },
      success: function success(data) {
        $('#logError').html(data);

        if ($.isNumeric(data)) {
          $('#logError').html("");
          $(".setUsernameBox").slideDown();
        }
      }
    });
  });
  $("#setUsernameBtn").click(function (e) {
    e.preventDefault();
    validateUsername();
  });

  function validateUsername() {
    var username = $("#usernameInput").val();
    var check = checkUsername(username);

    if (check === true) {
      return $.ajax({
        url: "usernameCheck",
        type: "post",
        dataType: "json",
        data: {
          "newUsername": username
        },
        success: function success(data) {
          if (data.status) {
            $('#usernameError').html("");
            location.reload();
          }

          $('#usernameError').html(data);
        }
      });
    }
  }

  function checkUsername(username) {
    if (username.length <= 3 || username.value === "" || /[^A-Za-z\d]/.test(username)) {
      document.getElementById("usernameError").innerHTML = "Your username must contain at least 4 characters";
      return false;
    }

    document.getElementById("usernameError").innerHTML = "";
    return true;
  }

  $("#userRegBtn").click(function () {
    var regName = $("#regName").val();
    var regEmail = $("#regEmail").val();
    var regPass = $("#regPass").val();
    $.ajax({
      url: "registerUser",
      type: 'post',
      data: {
        'action': 'register-task',
        'userName': regName,
        'userEmail': regEmail,
        'userPass': regPass
      },
      success: function success(data) {
        if (data.status) {
          console.log(data);
          location.reload();
        } //   $('#regError').html(data);

      }
    });
  });
});