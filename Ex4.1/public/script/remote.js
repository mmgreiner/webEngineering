var currentImage = 0; // the currently selected image
var currentZoom = 0; // the current zoom level
var imageCount = 7; // the maximum number of images available

var selectTimeout;
var zoomTimeout;

var socket;
var currentScreenList;

// Modulo behavior for negative numbers is weird
// lets fix this (source: http://stackoverflow.com/a/4467559)
Number.prototype.mod = function(n) {
    return ((this%n)+n)%n;
};

function showImage (index){
    // Update selection on remote
    currentImage = index;
    console.log("showImage: " + index);
    var images = document.querySelectorAll("img");
    var selectedImages = document.querySelector("img.selected");

    if (selectedImages) {
        selectedImages.classList.toggle("selected");
    }

    images[index].classList.toggle("selected");

    // Send the command to the screen
    // TODO
    //alert("TODO send the index to the screen")

    socket.emit('selected image', index);
}

function zoomImage(zoomLevel) {

    socket.emit('zoom image', {'id': currentImage, 'zoomLevel': zoomLevel});
}

function initialiseGallery(){
    var container = document.querySelector('#gallery');
    var i, img;
    for (i = 0; i < imageCount; i++) {
        img = document.createElement("img");
        img.src = "images/" +i +".jpg";
        document.body.appendChild(img);
        var handler = (function(index) {
            return function() {
                showImage(index);
            }
        })(i);
        img.addEventListener("click",handler);
    }

    document.querySelector("img").classList.toggle('selected');
}

document.addEventListener("DOMContentLoaded", function(event) {
    initialiseGallery();

    document.querySelector('#toggleMenu').addEventListener("click", function(event){
        var style = document.querySelector('#menu').style;
        style.display = style.display == "none" || style.display == ""  ? "block" : "none";
    });
    connectToServer();

    // When the DOM is ready, we initialise the Mobile phone stuff
    initialiseMobile();
});

function connectToServer(){
    // TODO connect to the socket.io server
    
    socket = io({query: "name=remote"});
    
    socket.on('screens', function(screens){
        
        currentScreenList = screens;
        
        console.log(screens);

        //first clear menu
        $('#menu').empty();
        
        //populate menu with screens
        for (i = 0; i < screens.length; i++) { 
            //$('#menu').append($('<li>').text(screens[i]));
            var screenId = screens[i][0];
            /*console.log(screenId);
            console.log(screenName);
            console.log(screens[i][2]);*/
            var screenName = screens[i][1];
            var buttonText = "connect";
            if(screens[i][2] === 'connected') {
                var buttonText = "disconnect";  
            }
            //$('#menu').append($('<li>'+screenName+'<input type="button" id=screenIndex'+i+' value='+buttonText+' onclick="changeConnectionInfo('+i+')"/>'));
            $('#menu').append($('<li>'+screenName+'<button id=screenIndex'+i+' onclick="changeConnectionInfo('+i+')">'+buttonText+'</button>'));
        }
    });
}

function changeConnectionInfo(screenIndex) {
    //console.log(screenIndex);
    var currentValue = $("#screenIndex" + screenIndex).html();
    //console.log(currentValue);
    if(currentValue == 'connect') {
        $("#screenIndex" + screenIndex).html('disconnect');
    } else {
        $("#screenIndex" + screenIndex).html('connect');
    }
    
    socket.emit('connection changed', currentScreenList[screenIndex][0]);
}

function onOrientationChange(tiltLR, tiltFB, dir) {

    var offsetLR = 20;
    var offsetFB_1 = 25;
    var offsetFB_2 = 50;
    var offsetFB_3 = 70;

    // Set the debounce time in milliseconds
    // this will give the user some time for the
    // interaction
    var debounceTime = 1000;

    // Select picture on the left
    if (tiltLR < -offsetLR && !selectTimeout) {
        selectTimeout = setTimeout(function() {
            // 0 - imageCount -> index
            showImage((currentImage - 1).mod(imageCount));
            console.log(tiltLR, tiltFB, dir);
            selectTimeout = null;
        }, debounceTime);
    }
    // Select picture on the right
    else if (tiltLR > offsetLR && !selectTimeout) {
        selectTimeout = setTimeout(function() {
            showImage((currentImage + 1).mod(imageCount));
            selectTimeout = null;
        }, debounceTime);  
    }

    // we should debounce this
    // the device orientation is called very often, even if the phone is
    // laying on the table
    // we dont want to zoom to level 4 very quickly but give the user
    // some time

    // zoom into current picture

//-------------------- first attempt -------------------//
    /*if (tiltFB > offsetFB) {
        
        //setTimeout(function(){

        //}, 100);
        currentZoom = Math.min(currentZoom + 1, 3);

        zoomImage(currentZoom);
        console.log(currentZoom);
    }
    // zoom out of current picture
    else if (tiltFB < 0) {
        currentZoom = 0

        zoomImage(currentZoom);
        console.log(currentZoom);
    }*/

//-------------------- first attempt -------------------//

if(tiltFB < 0){
    currentZoom = 0;
    zoomImage(currentZoom);

}else if(tiltFB > 0 && tiltFB < offsetFB_1){
    currentZoom = 1;
    zoomImage(currentZoom);

}else if(tiltFB > offsetFB_1 && tiltFB < offsetFB_2){
    currentZoom = 2;
    zoomImage(currentZoom);

}else{
    currentZoom = 3;
    zoomImage(currentZoom);

}

    //console.log(tiltLR, tiltFB, dir);
}

function initialiseMobile() {
    // Check if there is a DeviceOrientationEvent property on the window object
    // ==> device orientation is available
    if (window.DeviceOrientationEvent) {

        // Listen for the deviceorientation event and handle the raw data
        window.addEventListener('deviceorientation', function(eventData) {

            // gamma is the left-to-right tilt in degrees, where right is positive
            var tiltLR = eventData.gamma;

            // beta is the front-to-back tilt in degrees, where front is positive
            var tiltFB = eventData.beta;

            // alpha is the compass direction the device is facing in degrees
            var dir = eventData.alpha;

            // call our orientation event handler
            if (tiltLR !== null || tiltFB !== null || dir !== null){
                onOrientationChange(tiltLR, tiltFB, dir);
            }

        }, false);
    }
}