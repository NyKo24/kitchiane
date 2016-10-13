var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});
app.get('/sass.css', function(req, res){
  res.sendFile(__dirname + '/sass.css');
});

io.on('connection', function(socket){
  console.log('a user connected');
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });

  

  socket.on('chat message', function(objMessage){
    console.log('message: ' + objMessage.message + " " + objMessage.from);
   	
    io.emit('chat message', objMessage);
  });

});

http.listen(3000, function(){
  console.log('listening on *:3000');
});