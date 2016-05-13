//Express initializes app to be a function handler 
//that can supply to an HTTP server
var express = require('express');
var app = express();
var http = require('http').Server(app);

//create new instance of socket.io
//by passing a reference to the http object
//no URL specification is needed since it defaults 
//to trying to connect to the host that serves the page
var io = require('socket.io')(http);

app.use(express.static('public'));

http.listen(8080, function(){
    console.log('listening on *:8080');
});

var screens = [];				//collection of screens
var remotes = [];				//collection of remotes
var currentImageIndex = 0;		//keeps track of the current image index (initially set to 0)

//listen on the connection event for incoming sockets
io.on('connection', function(socket){
	
	//get name of connected socket
    var  name = socket.handshake.query.name;
	console.log('user connected: ' + name + ' / id: ' + socket.id);	
	
	//screens have names like screen1, screen2, etc.
	//remotes don't forward a name -> name is undefined
	if(typeof name === 'undefined') {
		remotes.push(socket);
		socket.join('remotes');
	} else {
		screens.push([socket, 'disconnected']);
		socket.join('screens');
	}
		
	//disconnect event
	socket.on('disconnect', function(){
		if(typeof name != 'undefined') {
			var index = screens.findIndex(x => x[0].id == socket.id);
			console.log('user disconnected: ' + name + ' with array index ' + index);
			screens.splice(index, 1);
			
			//forward updated list to remote and image index to all connected screens
			forwardSocketNamesToRemoteControl();
			forwardPicturesToScreens();
		}
	});
	
	//selected image index event
	socket.on('selected image', function(index){
		console.log('selected image index: ' + index);
		currentImageIndex = index;
		
		//forward updated list to remote and image index to all connected screens
		forwardSocketNamesToRemoteControl();
		forwardPicturesToScreens();
	});
	
	//event if a connection information of a screen has changed
	socket.on('connection changed', function(index){
		console.log("connection change: " + index);
		var lastStatus = screens[index][1];
		if(lastStatus == 'connected') {
			screens[index][1] = 'disconnected';
		} else {
			screens[index][1] = 'connected';
		}
		
		//forward updated list to remote and image index to all connected screens
		forwardSocketNamesToRemoteControl();
		forwardPicturesToScreens();
	});
	
	//forward updated list to remote and image index to all connected screens
	forwardSocketNamesToRemoteControl();
	forwardPicturesToScreens();
});

//function to update the list with screens on the remote control
function forwardSocketNamesToRemoteControl() {
	screenNames = [];
	console.log("Overview:");
	for (i = 0; i < screens.length; i++) { 
		console.log(screens[i][0].id + " " + screens[i][0].handshake.query.name + " " + screens[i][1]);
		screenNames.push([screens[i][0].id, screens[i][0].handshake.query.name, screens[i][1]]);
	}
	io.to('remotes').emit('screens', screenNames);
}

//function to forward the image index to the screens
function forwardPicturesToScreens() {
	var activeScreensCounter = 0;
	for (i = 0; i < screens.length; i++) {
		console.log('image with index ' + (currentImageIndex + i) + ' will be sent');
		//only forward image index to screens that are currently connected
		if(screens[i][1] === 'connected') {
			io.sockets.connected[screens[i][0].id].emit('image index', (currentImageIndex + activeScreensCounter));
			activeScreensCounter = activeScreensCounter + 1;
		} else {
			io.sockets.connected[screens[i][0].id].emit('image index', -1);
		}
	}
}