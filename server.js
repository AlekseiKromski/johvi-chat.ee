let http = require('http').Server();
let io = require('socket.io')(http);
let Redis = require('ioredis');

let redis = new Redis();
redis.subscribe('message-room');
redis.subscribe('join-user');
redis.psubscribe('private-message.*');
redis.psubscribe('user-channel.*');

redis.on('message', function (channel, message){
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ":" + message.event, message.data);
});

redis.on('pmessage', function (pattern, channel, message){
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ":" + message.event, message.data);
});

redis.on('pchannel', function (pattern, channel, message){
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ":" + message.event, message.data);
});

redis.on('join-user', function (channel, message){
    console.log(message);
    message = JSON.parse(message);
    io.emit(channel + ":" + message.event, message.data);
});

http.listen(3000, function (){
    console.log('Start server')
})
