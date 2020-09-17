$('#privateRoomBtn').click(function(){

    // e.preventDefault();
     var userText = $("#privateRoomMsg").val();
    console.log(userText);
    // resetForm();
    // savePrivateMsg(userText).done(function(data){
    // if(data > 0){
    //     // showData(data);
    // }
    // });
});

// function savePrivateMsg(userText){
     
//       return $.ajax({

//         url: global_var.siteUrl + "room/roomIndex",
//         type: "post",
//         data: {
//             "sendText" : text,
//             "chaUserId": chatId
//         },
//         success: function(response){
//             // checkForNewMsg();              
//         }
//     });
// }
