

// Callback function
// gets executed whenever we take something from
// the history stack --> for example by pressing the
// back button in the browser
window.onpopstate = function(event) {
    console.log(event.state);
    var stateObject = event.state;
    var currentUrl = document.location;

    // stateObject only is !== null and has an id property
    // when we pushed it on the history stack
    if (stateObject !== null && stateObject.overview) {
        resetDetails();
    }
};

function displaySinglePost(url, id) {
    var content = loadFullContent(url, function(content){
        insertDetails(content, id);
    });
    /* Replace the current content with the new one */
}

function loadFullContent(url, callback) {

    // $.get(url, callback);

    var xmlhttp;
    xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", url, true);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            callback(xmlhttp.responseText);
        }
    };
    xmlhttp.send();
}

function insertDetails(content, id) {
    $overview = $('#blogcontainer');
    // Take the current element
    //$elem = $('#' + id);
    //var $elem = $('#blogcontainer > article:first');

    // Hide the Overview
    $overview.hide();

    // Create the details view
    $details = $('<div>' + content + '</div>')
        .attr('id', 'blogdetails')
        .attr('class', 'blogitem');
       


    //$content.find('.blogtext > div').html(content);
    $details.find('.blogtext > div').append('<span onclick="resetDetails(true)"> Go back</span>');

    // Add the Details View
    $details.insertAfter($overview);

    // Set this state by default
    // so we know afterwards
    history.replaceState({"overview": true}, document.title, location.href);

    //Adapt the URL
    var stateObject = {'id': id};
    var stateTitle = document.title; // just use current title
    var stateUrl = "#!" + id;
    history.pushState(stateObject, document.title, "#!" + id);
}

function resetDetails(forceBack) {
    $overview = $('#blogcontainer');
    $details = $('#blogdetails');

    $details.remove();
    $overview.show();

    if (forceBack) {
        // Going back to the previous URL in the history
        window.history.back();
    }
}
