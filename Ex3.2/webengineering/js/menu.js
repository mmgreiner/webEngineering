// MAM - Michael, Andrea, Markus


/* ********* Animation of the Menu

*/

// Create a counter object
var counter = {};
var timerRunning = {};
var imgMax = 48, imgMin = 16;
var sections = ['#home', '#about', '#portfolio', '#blog', '#contact'];

function getMostFrequentCounts() {
    var maxCounts = 1;

    // iterate over all properties of the counter object
    for (var elem in counter) {
        // Check if the elem is not a native property
        // because this could happen in some cases
        if (counter.hasOwnProperty(elem)) {
            if (counter[elem] > maxCounts) {
                maxCounts = counter[elem];
            }
        }
    }

    return maxCounts;
}

function updateMenu(){
    
    // Loop over the array values (and not the keys)
    sections.forEach(function(section){

        // Select the a element with href equal to the section
        // from this a select the children that are from type img
        // only "first level" children
        var $img = $("a[href='" + section + "'] > img");
        
        var mf = getMostFrequentCounts();
        var sf = 1;

        // take the counter value only if it exists
        // to prevent accessing nonexisting elements
        if (counter[section]) {
            sf = counter[section];
        }

        var size = sf/mf * (imgMax - imgMin) + imgMin;
    
        $img.animate({'width': size});
    });
}

function getHeightDivisions(section){
    return $(section).offset().top;
}

function startTimer(section, func){
    // If there is already a timer running
    // we dont need to do anything
    if (timerRunning[section]){
        return;
    }
    
    // Delay in ms
    var delay = 2000;

    window.setTimeout(function(){
        func();
        timerRunning[section] = false;
    }, 2000);
    timerRunning[section] = true;
}

function getCurrentSection(scrollTop){

    if(scrollTop > getHeightDivisions($("#about")) && scrollTop < getHeightDivisions($("#portfolio"))){
        return "#about";
    }
    else if(scrollTop > getHeightDivisions($("#portfolio"))  && scrollTop < getHeightDivisions($("#blog"))){
        return "#portfolio";
    }
    else if(scrollTop > getHeightDivisions($("#blog"))  && scrollTop < getHeightDivisions($("#contact"))){
        return "#blog";
    }
    else if(scrollTop > getHeightDivisions($("#contact"))){
        return "#contact";
    }
    else {
        return "#home";
    }
}

$(window).scroll(function () {
    console.log("test");
    var scrollTop = $(document).scrollTop();

    var currentId = getCurrentSection(scrollTop);
    console.log("currentId" + currentId);

    startTimer(currentId, function(){

        var scrollTopAfterDelay = $(document).scrollTop();
        
        if(currentId == getCurrentSection(scrollTopAfterDelay)){
            // if this counter already exists
            // hence the property of the counter object exists
            if (counter[currentId]){
                counter[currentId] += 1;
            }
            // if not we can just set it to 1
            // this will create a property on the counter object
            else {
                counter[currentId] = 1;
            }

            updateMenu();
        }
    });
});

