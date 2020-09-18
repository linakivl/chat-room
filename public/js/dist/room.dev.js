"use strict";

$(document).ready(function () {
  var chatRoomId = $("#chat-window").data("chat-id");
  var lastMsgRoomId = null;
  checkNewPrivateMsg();
  $('#privateRoomBtn').click(function (e) {
    e.preventDefault();
    var userText = $("#privateRoomMsg").val();
    resetInput();
    saveTextToDb(userText);
  });

  function saveTextToDb(userText) {
    $.ajax({
      url: global_var.siteUrl + "room/savePrivateText",
      type: "post",
      data: {
        "userText": userText,
        "chatRoomId": chatRoomId
      },
      success: function success(response) {
        checkNewPrivateMsg();
      }
    });
  } // function appendOnlineChats(){
  //     $.ajax({
  //         url:  global_var.siteUrl + "room/appendChatsController",
  //         type: "post",
  //         dataType: 'json',
  //         data:{
  //             "lastIdMsg": $lastId
  //         },success: function(response){
  //             if(response.status){
  //                 $(".chat-box-chatlist").append(response.username);
  //             }
  //         }
  //     });
  // }


  function checkNewPrivateMsg() {
    $.ajax({
      url: global_var.siteUrl + "room/getPrivateMsgs",
      type: "post",
      dataType: 'json',
      data: {
        "chatUserId": chatRoomId,
        "lastMsgRoomId": lastMsgRoomId
      },
      success: function success(response) {
        if (response.status) {
          $(".chat-box_wrapper").append(response.messages);
          lastMsgRoomId = response.lastId;
          $('.chat-box_wrapper').scrollTop($('.chat-box_wrapper')[0].scrollHeight);
        }
      }
    });
  }

  setInterval(function () {
    checkNewPrivateMsg();
  }, 5000);

  function resetInput() {
    document.getElementById("roomInputForm").reset();
  }
});