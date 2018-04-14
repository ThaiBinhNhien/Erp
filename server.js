var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3000;
var verify_token = 'zXkRE3w4i1b7AERiFkgyCCg7UQaV4ReT';

server.listen(port, function () {
  console.log('Server listening at port %d', port); 
});


// Connection 
io.on('connection', function (socket) {
  socket.auth = false;
  socket.on('authenticate', function(data){
    if(verify_token == data.token) {
      socket.auth = true;
    }
    /*checkAuthToken(data.token, function(err, success){
      if (!err && success){
        console.log("Authenticated socket ", socket.id);
        socket.auth = true;
      }
    });*/
  });

  // Disconnect after 1s not authentication
  setTimeout(function(){
    if (!socket.auth) {
      console.log("Disconnecting socket ", socket.id);
      socket.disconnect('unauthorized');
    }
  }, 1000);

  // room
  socket.on('room', function(room) {
    socket.join(room);
  });

  // count message
  socket.on( 'new_count_message', function( data ) {
    io.sockets.in(data.username).emit( 'new_count_message', { 
    	new_count_message: data.new_count_message
    });
  });

  // update number message
  socket.on( 'update_count_message', function( data ) {
    io.sockets.in(data.username).emit( 'update_count_message', {
    	update_count_message: data.update_count_message 
    });
  });

  // message new
  socket.on( 'new_message', function( data ) {
    io.sockets.in(data.username).emit( 'new_message', {
    	username: data.username,
      subject: data.subject,
      message: data.message,
    	created_at: data.created_at,
    	id: data.id
    });
  });

  socket.on('disconnect', function(data) {
    console.log("Disconnect Server");
  });

  
});