//if value is less than 10 pads it with a zero to make it a two digit number (e.g. 1 -> 01, 2 -> 02, 3 -> 03)
function padTen(val) {
    return (val < 10 ? '0' : '') + val;
}

//gets a time in an HH:MM format as a string from date
function getTimeString(date) {
    return padTen(date.getHours()) + ':' + padTen(date.getMinutes());
}

//gets a date in a DD/MM/YYYY format as a string from date
function getDateString(date) {
    return padTen(date.getDate()) + '/' + padTen(date.getMonth() + 1) + '/' + date.getFullYear();
}

//convert an array of periods to a readable string array with each element as ["startPeriod: _________ endPeriod:___________"]
function periodsToReadablePeriods(periods) {
    var readablePeriods = [];
    for (var i in periods) {
        var startDate = new Date(periods[i].startPeriod);
        var endDate = new Date(periods[i].endPeriod);
        readablePeriods.push("startDate: " + startDate + " endDate: " + endDate);
    }
    return dates;
}
