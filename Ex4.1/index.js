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

//listen on the connection event for incoming sockets
io.on('connection', function(socket){
    
    //get name of connected socket
    var name = socket.handshake.query.name;
	if (name === undefined) {
		console.log("an older socket still running with wrong arguments, aborting");
	}
	console.log('user connected: ' + name + ' / id: ' + socket.id);	
    
    //screens have names like screen1, screen2, etc.
	//remotes have remote as name
	if(name.includes("remote")) { 
		//store default image index in nickname and join room with all remotes
		socket.nickname = 0;
        socket.join('remotes');
	} else if(name.includes("screen")) {
		//store name in attribute nickname and join room with all screens
		socket.nickname = name;
		socket.join('screens');
		//clear screen
		io.sockets.connected[socket.id].emit('image index', -1);
    }
        
    //disconnect event
    socket.on('disconnect', function(){
		console.log('user disconnected: ' + name);
		if(name.includes("remote")) {
			//need to clean up all screens connected by this remote
			var remoteRoom = io.nsps['/'].adapter.rooms[socket.id];
			if(remoteRoom != undefined) {
				for (var screenSocketId in remoteRoom.sockets) {
					if(screenSocketId != socket.id) {
						console.log('screen is cleared');
						io.sockets.connected[screenSocketId].emit('image index', -1);
					}
				}
			}
		}
			
		//forward updated list of screens to remote
		forwardSocketNamesToRemoteControl();
	});
	
	//selected image index event
	socket.on('selected image', function(imageIndex){
		console.log('selected image changed');
		//keep track of currently selected image in attribute nickname of remote
		socket.nickname = imageIndex;
		
        //forward updated list to remote and image index to all connected screens
        forwardPicturesToScreens(socket.id);
	});
	
	socket.on('zoom image', function(obj){
        console.log('zoom image index: ' + obj.id, obj.zoomLevel);
        // currentImageIndex = obj.id;

        //forward updated list to remote and image index to all connected screens
        //forwardSocketNamesToRemoteControl();
        // forwardPicturesToScreens();
        performZoom(obj.zoomLevel);
    });
    
    //event if a connection information of a screen has changed
	socket.on('connection changed', function(screenId){
		console.log('status update for remote ' + socket.id + ' and screen ' + screenId);
		var status = 'disconnected';
		//if screen is in room of remote => leave room
		if (io.sockets.adapter.sids[screenId][socket.id]) {
			console.log('leave');
			io.sockets.connected[screenId].leave(socket.id);
			
			//in addition we need to clear the display of the screen
			io.sockets.connected[screenId].emit('image index', -1);
		} else { //otherwise join
			console.log('join');
			io.sockets.connected[screenId].join(socket.id);
		} 
		
		//forward image index to all connected screens
		forwardPicturesToScreens();
	});
	
	//forward updated list to remote and image index to all connected screens
	forwardSocketNamesToRemoteControl();
	forwardPicturesToScreens();
});

//function to update the list with screens on the remote control
function forwardSocketNamesToRemoteControl() {
	console.log('forward list with sockets to remotes');
	//get the rooms for all remotes and iterate them
	var remotesRoom = io.nsps['/'].adapter.rooms['remotes'];
	if(remotesRoom != undefined) {
		for (var remoteSocketId in remotesRoom.sockets) {
			screenNames = [];
			//iterate over all screens in the screen-room
			//and check whether they are in the current remote room
			//if this is the case add the screen to screenNames
			var screenRoom = io.nsps['/'].adapter.rooms['screens'];
			if(screenRoom != undefined) {
				for (var screenSocketId in screenRoom.sockets) {
					var status = 'disconnected';
					if (io.sockets.adapter.sids[screenSocketId][remoteSocketId]) {
						status = 'connected';
					}
					screenNames.push([screenSocketId, io.sockets.connected[screenSocketId].nickname, status]);
				}	
				//forward list with screen names to the remote
				io.sockets.connected[remoteSocketId].emit('screens', screenNames);
			}
		}
	}
}

//function to forward the image index to the screens
function forwardPicturesToScreens(remoteSocketId) {
	console.log('forward picture to screens');
	console.log('test');
	//if remoteSocketId specified -> update all connected screens of that remote
	if (remoteSocketId != undefined) {
		var remotesRoom = io.nsps['/'].adapter.rooms[remoteSocketId];
	//otherwise update all screenSocketId
	} else { 
		var remotesRoom = io.nsps['/'].adapter.rooms['remotes'];
	}
	if(remotesRoom != undefined) {
		/*for (var remoteSocketId in remotesRoom.sockets) {
			var activeScreensCounter = 0;
			var remoteRoom = io.nsps['/'].adapter.rooms[remoteSocketId];
			if(remoteRoom != undefined) {
				for (var screenSocketId in remoteRoom.sockets) {
					if(screenSocketId != remoteSocketId) {
						var imageIndex = io.sockets.connected[remoteSocketId].nickname;
						io.sockets.connected[screenSocketId].emit('image index', imageIndex + activeScreensCounter);
						activeScreensCounter = activeScreensCounter + 1;
					}
				}
			}
		}*/
		console.log(remotesRoom);
		for (var remoteSocketId in remotesRoom.sockets) {
			var activeScreensCounter = 0;
			var screenRoom = io.nsps['/'].adapter.rooms['screens'];
			console.log(screenRoom);
			if(screenRoom != undefined) {
				for (var screenSocketId in screenRoom.sockets) {
					if (io.sockets.adapter.sids[screenSocketId][remoteSocketId]) {
						if(screenSocketId != remoteSocketId) {
							var imageIndex = io.sockets.connected[remoteSocketId].nickname;
							io.sockets.connected[screenSocketId].emit('image index', imageIndex + activeScreensCounter);
							activeScreensCounter = activeScreensCounter + 1;
						}
					}
				}	
			}
		}
	}	
}

function performZoom(zoomLevel) {
    var activeScreensCounter = 0;
    for (i = 0; i < screens.length; i++) {
        if(screens[i][1] === 'connected') {
            io.sockets.connected[screens[i][0].id].emit('image zoom', {id: (currentImageIndex + activeScreensCounter), zoomLevel: zoomLevel});
            activeScreensCounter += 1;
        }
    }
}