// MAM - Michael, Andrea, Markus
// 

"use strict";



/* ********* Animation

Animate first time, if a DOM element appears in the current view port
When the page loads, the elements appear on the screen
on scrolling, also once they appear.

*/

function myFade(ev)
{
    // fade in the paragraphs
    $("p", ev.target).fadeIn("slow");
};

function Animator(sel)
{
    $(sel).mouseover(function(){
        $("p", this).fadeIn(1500);
    });
    $(sel).scroll(function(){
       $("p", this).fadeIn(2000); 
    });
}

function homeHeader() {
    var sel = "#home header";
    var par = "#home p";
    console.log("homeHeader " + sel + " " + par);
    /*
    $(sel).mouseover(function() {
        console.log("mouseover");
        $(par).fadeIn("slow");
    });
    */
    $(sel).mouseover(myFade);

    $(sel).scroll(function() {
        console.log("scroll");
        $(par).fadeIn("slow");
    });
};


$(document).ready(function() {
    // alert("Created by MAM");
    console.log("ready");

    Animator("#home header");
    Animator("#about"); 
    Animator("#partdesigner");
    Animator("#partcoder");
    //homeHeader();
    //$("#home header p").hide();
    
});

// ****** animation *********


/*
$("section#home").hover(
    function() {
        console.log("hover in");
        $("#home header").fadeIn();
    },
    function() {
        $("home header").fadeOut();
    }    
);
*/

