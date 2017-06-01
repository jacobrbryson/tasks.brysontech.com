var navDate = document.getElementById("nav_date");

function updateClock(){
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var M = today.getMonth();
    var day = today.getDate();
    var year = today.getFullYear();
    var amPM = "a";
    amPM = checkAMPM(h);
    h = fixHour(h);
    m = checkTime(m);
    M = fixMonth(M);
    navDate.innerHTML = M + " " + day + ", " + year + " " + h + ":" + m + amPM;
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    };  // add zero in front of numbers < 10
        return i;
}
    
function fixHour(h){
    if(h > 12){
        h = h - 12;
    }
    return h;
}

function checkAMPM(h){
    if(h > 11){
        return "p";
    } else {
        return "a";
    }

}
function fixMonth(M){
    var months = [
        'Jan',
        'Feb',
        'Mar',
        'April',
        'May',
        'June',
        'July',
        'Aug',
        'Sept',
        'Nov',
        'Dec'
    ];

    return months[M];
}

updateClock();

clock = setInterval(function() {
    updateClock();
}, 60 * 1000);