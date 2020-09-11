"use strict";

$(document).ready(function () {
  var lastMsgId = null;
  var chatId = $('#chat-window').data('chat-id');
  displayOnlineUsers();
  displayMessages();
  checkForNewMsg();
  $("#logOutBtn").click(function (e) {
    console.log("he");
    e.preventDefault();
    var offline = 0;
    $.ajax({
      url: global_var.siteUrl + "chat/changeStatus",
      type: "post",
      data: {
        'userStatus': offline
      },
      success: function success(response) {
        $.ajax({
          url: global_var.siteUrl + "chat/logoutUser",
          success: function success(response) {
            location.reload();
          }
        });
      }
    });
  });

  function checkForNewMsg() {
    if (lastMsgId) {
      $.ajax({
        url: global_var.siteUrl + "chat/checkNewMsg",
        type: "post",
        data: {
          "lastMessageId": lastMsgId
        },
        success: function success(response) {
          console.log(response);

          if (response) {
            $('.chatMessages').append(response);
            $('#container-chatMessages_box').scrollTop($('#container-chatMessages_box')[0].scrollHeight); // displayMessages();
            // lastMsgId = response;       
          }
        }
      });
    } // lastMsgId = null;

  }

  function displayOnlineUsers() {
    $.ajax({
      url: global_var.siteUrl + "chat/onlineUsersStatus",
      success: function success(response) {
        $('#activeUserBox').html(response);

        if (response == false) {
          $('#activeUserBox').html("");
        }
      }
    });
  }

  setInterval(function () {
    // displayOnlineUsers();
    checkForNewMsg();
  }, 5000);
  $('#mainchatBtn').click(function (e) {
    e.preventDefault();
    var userText = $("#mainchatText").val();
    resetForm();
    saveData(userText).done(function (data) {
      if (data > 0) {// showData(data);
      }
    });
  });

  function saveData(text) {
    return $.ajax({
      url: global_var.siteUrl + "chat/sendLineToDb",
      type: "post",
      data: {
        "action": "sendLineToDb",
        "sendText": text
      },
      success: function success(response) {
        lastMsgId = response;
        checkForNewMsg();
      }
    });
  }

  function displayMessages() {
    if (Number.isInteger(chatId)) {
      displayPrivateMsgs(chatId);
    } else {
      displayPublicMsgs();
    }
  }

  function displayPublicMsgs() {
    $.ajax({
      url: global_var.siteUrl + "chat/getAllPublicMessages",
      success: function success(response) {
        //this line of code force the user to not scroll up/ 
        $('#container-chatMessages_box').html(response);
        $('#container-chatMessages_box').scrollTop($('#container-chatMessages_box')[0].scrollHeight);
      }
    });
  }

  function displayPrivateMsgs($chatid) {
    $.ajax({
      url: global_var.siteUrl + "chat/getAllRoomMessages",
      data: {
        "chatid": $chatid
      },
      success: function success(response) {/////////////////
      }
    });
  }

  function resetForm() {
    document.getElementById("inputText").reset();
  }

  $('body').on('click', '.online-user', function (e) {
    var userId = $(e.currentTarget).data('tasks-id');
    chatId = userId;
    $.ajax({
      url: global_var.siteUrl + "chat/room",
      type: "post",
      data: {
        "userId": userId
      },
      success: function success(response) {
        $('.container-chat_box').html(response);
        displayMessages();
      }
    });
  });
});