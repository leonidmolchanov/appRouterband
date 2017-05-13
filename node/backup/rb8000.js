var express = require('express');
var app = express();
var http = require('http');
var url = require('url');
var mysql = require('mysql');
var request = require('request');
var server = http.createServer(app);
var ping = require ("net-ping");
var io = require('socket.io').listen(server);
var snmp = require('snmp-native');


io.on('connection', function (socket) {
socket.on('eventServer', function (data) {

//console.log(socket.id);
	console.log(data.data);




var connection = mysql.createConnection(
    {
      host     : 'localhost',
      user     : 'root',
      password : 'LikeFly1986',
      database : 'wordpress',
    }
);




var queryString3 = "SELECT * FROM wp_users  WHERE user_login='"+data.data+"'";
//console.log(queryString3)
connection.query(queryString3, function(err, rows, fields) {
    if (err) console.log(err);


var balance = rows[0].BALANCE;
var queryString4 = "SELECT * FROM radius.radreply  WHERE username='"+rows[0].SN+"'";
var ms;
var string;
var cpuwork;
connection.query(queryString4, function(err, rows, fields) {
    if (err) console.log(err);
//console.log(rows[0].value);

var target = rows[0].value;





//Princip raboti callback*****

//Eta funcia obertka, v nee nuzno zavernut cod i peredat dlia coda parametry
function cpu(target,callback)
{
//sam cod
var session2 = new snmp.Session();
var session2 = new snmp.Session({ host:  target, community: 'public' });
session2.get({ oid: '.1.3.6.1.2.1.25.3.3.1.2.1' }, function (error, varbinds) {
    if (error) {
        console.log( error);
    } else {
        console.log(varbinds[0].oid + ' = ' + varbinds[0].value + ' (' + varbinds[0].type + ')');
    cpuwork=varbinds[0].value;
//v collbek pomeshaem nuznoe znatenie
    callback(cpuwork)
}
});
//conec coda i zakrivaem funkciu
}
// Eta fanctia vizova callbeka v nee preedaem nuznie parametri kotorie peredadutsia v osnovnuiu funciu




//Princip raboti callback*****

//Eta funcia obertka, v nee nuzno zavernut cod i peredat dlia coda parametry
function pingr(target,callback)
{
//sam cod

var session = ping.createSession ();
session.pingHost (target, function (error, target, sent, rcvd) {
    var ms = rcvd - sent;
    if (error)
        console.log (target + ": " + error.toString ());
    else
        console.log (target + ": Alive (ms=" + ms + ")");

callback(ms);
});

//conec coda i zakrivaem funkciu
}
// Eta fanctia vizova callbeka v nee preedaem nuznie parametri kotorie peredadutsia v osnovnuiu funciu



var pingr=pingr(target, function (num){ 
proc=num;
 string = {
  Balance: balance,
  ping: ms, 
cpu: num,
};
string = JSON.stringify(string);
	console.log(string);
	socket.emit('eventClient', { data: string });



});



var proc=cpu(target, function (num){ 
proc=num;
 string = {
  Balance: balance,
  ping: ms, 
cpu: num,
};
string = JSON.stringify(string);
	console.log(string);
	socket.emit('eventClient', { data: string });



});


});


	


	});
});
});
var port = 8000;
server.listen(port);












// о�п�ави�� �ек��ем� �оке�� ��о�ми�овав�ем� зап�о� (��да о�к�да п�и�ла)
//socket.emit('message', "this is a test");

// о�п�ави�� в�ем пол�зова�ел�м, вкл��а� о�п�ави�ел�
//io.sockets.emit('message', "this is a test");

// о�п�ави�� в�ем, к�оме о�п�ави�ел�
//socket.broadcast.emit('message', "this is a test");

// о�п�ави�� в�ем клиен�ам в комна�е (канале) 'game', к�оме о�п�ави�ел�
//socket.broadcast.to('game').emit('message', 'nice game');

// о�п�ави�� в�ем клиен�ам в комна�е (канале) 'game', вкл��а� о�п�ави�ел�
//io.sockets.in('game').emit('message', 'cool game');

// о�п�ави�� конк�е�ном� �оке��, по socketid
//io.sockets.socket(socketid).emit('message', 'for your eyes only');



