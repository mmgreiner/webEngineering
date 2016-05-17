"use strict";


if (window.DeviceOrientationEvent) {
    console.log("DeviceOrientation is supported");

    var x = $("#doEvent");
    x.innerHTML = "DeviceOrientation";
    
    // LIsten for device orientation event and handle data
    window.addEventListener("deviceorientation", function(eventData) {
        var tiltLR = eventData.gamma;
        var tiltFB = eventData.beta;
        var direct = eventData.alpha;
        deviceOrientationHandler(tiltLR, tiltFB, direct);
    }, false);
} else {
    console.log("DeviceOrientation is not supported");
    $("#doEvent").innerHTML = "not supported";
}

var Timer = Date.now();

var TimerWindow = 50;      // ms
var Threshhold = 20;
var BufferSize = 3;

var buffer = [];

var selected = 0;

var rex = /images\/(\d+)\.jpg/;

function lastImage()
{
    var last = document.querySelectorAll("img").length - 1;
    Log("lastImage" + last);
    return Number(last);
};

function currentImage()
{
    var img = document.querySelector("img.selected");
    var src = img.src;
    
    var matches = src.match(rex);
    var idx = matches[1];
    return Number(idx);
};

function logImage(txt)
{
    var i = currentImage();
    Log(txt + ": " + i);
    document.getElementById("imageIdx").innerText = i;
};

function selectNext(next)
{
    // if next is true, select the next image.
    // else the previous one
    
    var idx = currentImage();
    Log("selectNext " + next + "img " + idx);

    var newSel = -1;
    if (next) {
        if (idx == lastImage()) {
            newSel = 0;
        }
        else {
            newSel = idx + 1;
        }   
    }
    else {
        if (idx <= 0) {
            newSel = lastImage();
        }
        else {
            newSel = idx - 1;
        }
    }
    
    Log("selectNext: old is " + idx + " new is " + newSel);
    
    // deselect 
    var images = document.querySelectorAll("img");
    document.querySelector("img.selected").classList.toggle("selected");
    // set the new one to 
    images[newSel].classList.toggle("selected");
};

function deviceOrientationHandler(tiltLR, tiltFB, direct)
{
    var now = Date.now();       // milliseconds
    //Log("Timer: " + Timer + " Window: " + TimerWindow);
    
    if (now < Timer + TimerWindow) {
        return;
    }
    
    //Log("Now setting buffer");
    
    // now move it to the buffer
    buffer.push({LR: tiltLR, FB: tiltFB, DI: direct});
    
    if (buffer.length >= BufferSize) {
        // check which dimension has changed the most and above threshhold
        var first = buffer[0];
        var last = buffer.pop();
        var lrChange = Math.round(last.LR - first.LR);
        var fbChange = Math.round(last.FB - first.FB);
        var diChange = Math.round(last.DI - first.DI);
        //Log(lrChange + "/" + fbChange + "/" + diChange);
        if (Math.abs(lrChange) > Threshhold) {
            // left tilting gives negative values
            logImage("tilting");
            if (lrChange < 0) {
                Log("Tilted left, prev");
                selectNext(false);
            }
            else {
                Log("Tilted right, next");
                selectNext(true);
            }
        }
        if (Math.abs(fbChange) > Threshhold) {
            Log("Change forward backward");
        }
        if (Math.abs(diChange) > Threshhold) {
            Log("Change rotation");
        }
        
        // reset buffer
        buffer = [];
        
    }
    
    // reset timer
    Timer = now;
        
    // now often is this event handler called?    
    document.getElementById("doTiltLR").innerHTML = Math.round(tiltLR);
    document.getElementById("doTiltFB").innerHTML = Math.round(tiltFB);  
    document.getElementById("doDirection").innerHTML = Math.round(direct);
    Timer = now;
    
    
    // now wait for 1 sek and see where where are now.
    var rcolor = tiltLR * 250;
    var gcolor = tiltFB * 250;
    var bcolor = direct * 250;    
    // apply to picture
    //$("#box").css("background-color", "rgb(" + rcolor + "," + gcolor + "," + bcolor + ")");
}

function Log(str)
{
    var log = document.getElementById("log").innerHTML;
    log = Date.now() % 10000 + ": " + str + "<br>" + log;
    log = log.substr(1, 300);
    document.getElementById("log").innerHTML = log;
}

function changeColor()
{
    var rcolor = Math.floor((Math.random() * 250) + 1);
    var gcolor = Math.floor((Math.random() * 250) + 1);
    var bcolor = Math.floor((Math.random() * 250) + 1);
    
    $("#box").css("background-color", "rgb(" + rcolor + "," + gcolor + "," + bcolor + ")");
}