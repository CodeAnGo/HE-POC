function padTen(val) {
    return (val < 10 ? '0' : '') + val;
}

function getTimeString(date) {
    return padTen(date.getHours()) + ':' + padTen(date.getMinutes());
}

function getDateString(date) {
    return padTen(date.getDate()) + '/' + padTen(date.getMonth() + 1) + '/' + date.getFullYear();
}

function periodsToStartDates(periods) {
    var startDates = [];
    for (var i in periods) {
        startDates.push(new Date(periods[i].startPeriod));
    }
    return startDates;
}
