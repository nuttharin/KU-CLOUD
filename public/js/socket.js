const WS_URL = 'http://localhost:3000/'//$('meta[name=ws_url]').attr("content");
let USER_ID = getCookie("socket_token");

var socket = io(WS_URL, { query: "id= " + USER_ID });

socket.on('connect', function (data) {
    socket.emit('UserList', USER_ID);
});

socket.on('disconnect', function (data) {

});


socket.on('UserListRes', function (data) {
    //console.log(data);
});

// socket.on('broadcast', function (data) {
//     console.log(data);
// });