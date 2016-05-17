// test program for remote control tilting tests
var express = require("express");

var app = require('express')();
var http = require('http').Server(app);

app.use(express.static("public"));

app.get("/", function(request, response) {
  var fname = __dirname + "/public/tilt.html";
  console.log("fname =   " + fname);
  response.sendFile(fname);
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});

