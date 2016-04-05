// MAM - Michael, Andrea, Markus


/* ********* Animation

Animate first time, if a DOM element appears in the current view port
When the page loads, the elements appear on the screen
on scrolling, also once they appear.

Adopted from: http://justinaguilar.com/animations/
*/

"use strict";

function RandomSlide()
{
    // get a random number to determine how to animate
    var num = Math.floor(Math.random() * 4 + 1);
    return "slide" + num;    
}

$(document).ready(function() {
    $(".animate").each(function() {
        var elem = $(this).get()[0];
        console.log("elem " + elem.nodeName + " " + elem.id); 
    });
    
    
    $(window).scroll(function() {
        $(".animate").each(function() {
            var imagePos = $(this).offset().top;
            var topOfWindow = $(window).scrollTop();
            var height = $(window).innerHeight();
            // console.log("hit scrolling " + imagePos + " " + topOfWindow + " " + height);
            if (imagePos < topOfWindow+height) {
                var slide = RandomSlide();
                $(this).addClass(slide);
            }
        })
    });
})
