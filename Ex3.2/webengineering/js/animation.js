// MAM - Michael, Andrea, Markus


/* ********* Animation

Animate first time, if a DOM element appears in the current view port
When the page loads, the elements appear on the screen
on scrolling, also once they appear.

Adopted from: http://justinaguilar.com/animations/
*/

"use strict";

function RandomSlide() {
    // get a random number to determine how to animate
    var num = Math.floor(Math.random() * 4 + 1);
    return "slide" + num;
}

function AlreadySlided(node) {
    return $(node).hasClass("slide1") || $(node).hasClass("slide2") ||
        node.hasClass("slide3") || node.hasClass("slide4");
}

$(document).ready(function() {
    // on the first page there is no scroll
    if ($(window).scrollTop() == 0) {
        $("#home .animate").addClass(RandomSlide());
        $("#about .animate").addClass(RandomSlide());
    }

    $(window).scroll(function() {
        console.log("scrolltop " + $(window).scrollTop());
        $(".animate").each(function() {
            // if it already contains the class, skips("slide1"));
            if (!AlreadySlided($(this))) {
                
                var imagePos = $(this).offset().top;    
                var topOfWindow = $(window).scrollTop();
                var height = $(window).innerHeight();
                
                // console.log("hit scrolling " + this.localName + " " + imagePos + " < " + topOfWindow + " " + height);
                if (topOfWindow < imagePos && imagePos < topOfWindow + height) {
                    var slide = RandomSlide();
                    // console.log("sliding " + this.localName);
                    $(this).addClass(slide);
                }
            }
        })
    });
})
