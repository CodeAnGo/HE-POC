//Mapboxgl IControl class to add to top right of map containing information about a selected roadwork
class InfoControl {

    constructor(info) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'marker-info-box mapboxgl-ctrl';
        this._container.style.display = 'none';
        this._container.id = 'infoBox';
    }

    onAdd(map) {

        return this._container;
    }

    onRemove() {
        this._container.parentNode.removeChild(this._container);
        this._map = undefined;
    }
}

function getDescriptionHTML(desc, inclHeadings) {
    var descHTML = "<div><h3>Description</h3>";
    for (var i in desc) {
        var curDesc = desc[i].split(/:(.+)/);
        if (inclHeadings.includes(curDesc[0])) {
            descHTML = descHTML.concat("<div><h5>" + curDesc[0] + ": </h5><p>" + curDesc[1] + "</p></div>");
        }
    }
    descHTML = descHTML.concat('</div>');
    return descHTML;
}

function getCalendarHTML(periods) {

    console.log("CalendarHTML " + periodsToStartDates(periods));

    var activeDates = [];
    var activeStartDates = [];
    var activeEndDates = [];

    var startPeriod = new Date(periods[0].startPeriod);
    var endPeriod = new Date(periods[0].endPeriod);
    for (var i in periods) {

        startPeriod = new Date(periods[i].startPeriod);
        var startDate = startPeriod.getDate();
        activeStartDates.push(startDate);

        endPeriod = new Date(periods[i].endPeriod);
        var endDate = endPeriod.getDate();
        activeEndDates.push(endDate);

        for (var j = startDate; j < endDate + 1; j++) {
            activeDates.push(j);
        }
    }
    var curMonth = startPeriod.toLocaleString('default', {
        month: 'long'
    });
    var monthOffset = new Date(startPeriod.getFullYear(), startPeriod.getMonth(), 1).getDay() + 6;
    var daysInMonth = new Date(startPeriod.getFullYear(), startPeriod.getMonth(), 0).getDate();

    var scheduleHTML = `
    <div class="month">
      <ul>
        <li>` + curMonth + `<br><span style="font-size:18px">` + startPeriod.getFullYear() + `</span></li>
      </ul>
    </div>`;
    scheduleHTML = scheduleHTML.concat(`
    <ul class="weekdays">
        <li>Mo</li>
        <li>Tu</li>
        <li>We</li>
        <li>Th</li>
        <li>Fr</li>
        <li>Sa</li>
        <li>Su</li>
    </ul>

    <ul class="days">
    `);
    for (i = 1; i < 43; i++) {
        if (0 < i - monthOffset && i - monthOffset < daysInMonth) {
            if (activeDates.includes(i - monthOffset)) {
                var classString = "active ";
                if (activeStartDates.includes(i - monthOffset)) {
                    classString = classString.concat("active-start ");
                }
                if (activeEndDates.includes(i - monthOffset) && !(activeStartDates.includes(i - monthOffset+1))) {
                    classString = classString.concat("active-end ");
                }
                scheduleHTML = scheduleHTML.concat('<li class="' + classString + '">' + (i - monthOffset) + '</li>');
            } else {
                scheduleHTML = scheduleHTML.concat('<li>' + (i - monthOffset) + '</li>');
            }
        } else {
            scheduleHTML = scheduleHTML.concat('<li></li>');
        }
    }
    scheduleHTML = scheduleHTML.concat('</ul></div>');

    return scheduleHTML;
}

function getScheduleHTML(periods) {

    console.log("Schedule HTML" + periodsToStartDates(periods));
    var scheduleHTML = '<div class="schedule">';

    var curPeriod = periods[0];

    for (var i in periods) {
        curPeriod = periods[i];

        var curStartPeriod = new Date(curPeriod.startPeriod);
        var curEndPeriod = new Date(curPeriod.endPeriod);

        console.log("getDateString(curStartPeriod): " + getDateString(curStartPeriod) + "   getDateString(curEndPeriod): " + getDateString(curEndPeriod));
        if (getDateString(curStartPeriod) == getDateString(curEndPeriod)) {
                scheduleHTML = scheduleHTML.concat('<h5 class="time-slot">' + getDateString(curStartPeriod) + `</h5>
                    <div class="event">
                        <h5>` + getTimeString(curStartPeriod) + ' - ' + getTimeString(curEndPeriod) + `</h5>
                    </div>`);
        } else {
            scheduleHTML = scheduleHTML.concat('<h5 class="time-slot">' + getDateString(curStartPeriod) + ' - ' + getDateString(curEndPeriod) + `</h5>
                <div class="event">
                    <h5>` + getDateString(curStartPeriod) + ' ' + getTimeString(curStartPeriod) + ' - ' + getDateString(curEndPeriod) + ' ' + getTimeString(curEndPeriod) + `</h5>
                </div>`);
        }

    }
    scheduleHTML = scheduleHTML.concat('</div>');
    return scheduleHTML;
}

function getLanesHTML(lanes) {
    lanesHTML = '<hr><div><h3>Lanes</h3><div class="lanes row">';
    var colWidth = 12 / lanes.length;
    if (lanes.length == 5) {
        colWidth = 2;
    }
    for (var i in lanes) {
        var curLane = lanes[i];
        lanesHTML = lanesHTML.concat(`
            <div class="col-lg-` + colWidth + `">
                <div class = "lane ` + curLane.laneStatus + `">
                    <h5> ` + curLane.laneName + ` </h5>
                    <p> ` + curLane.laneStatus + ` </p>
                </div>
            </div>
            `);
    }

    lanesHTML = lanesHTML.concat('</div></div>');
    return lanesHTML;
}

function updateInfoBox(marker) {

    console.log("New Marker-----------------------------");

    var descriptionFilter = ["Location ", "Reason ", "Schedule ", "Period "];

    var periods = marker.properties.periods;
    console.log(periods);
    var scheduleHTML = "";
    if (periods.length != 1) {
        scheduleHTML = '<hr><div><h3>Schedule</h3>'
        descriptionFilter = ["Location ", "Reason "];
        var curPeriods = [periods[0]];
        for (var i = 1; i < periods.length; i++) {
            var tmpPeriod = periods[i];
            if (new Date(tmpPeriod.startPeriod).getMonth() === new Date(periods[i - 1].startPeriod).getMonth()) {
                curPeriods.push(tmpPeriod);
            } else {
                scheduleHTML = scheduleHTML.concat(getCalendarHTML(curPeriods));
                curPeriods = [];
            }
            curPeriods.push(tmpPeriod);
        }
        scheduleHTML = scheduleHTML.concat(getCalendarHTML(curPeriods) + '<hr>');
        scheduleHTML = scheduleHTML.concat(getScheduleHTML(periods));
        scheduleHTML = scheduleHTML.concat('</div>');
    }

    var desc = marker.properties.description;
    console.log(desc);
    var descHTML = getDescriptionHTML(desc, descriptionFilter);

    var lanes = marker.properties.lanes;
    console.log(lanes);
    var lanesHTML = "";
    if (lanes.length != 0) {
        lanesHTML = getLanesHTML(lanes);
    }

    document.getElementById('infoBox').innerHTML = descHTML + scheduleHTML + lanesHTML;
    document.getElementById('infoBox').style.display = 'block';
}
