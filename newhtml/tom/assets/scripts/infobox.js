//Mapboxgl IControl class containing information about a selected roadwork
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

//gets the HTML to display the formatted description of a roadwork event. Only displays sections with a heading in iclHeading.
function getDescriptionHTML(desc, inclHeadings) {
    var descHTML = "<div><h3>Description</h3>";
    for (var i in desc) {
        //split string by first occurence of ':''
        var curDesc = desc[i].split(/:(.+)/);
        if (inclHeadings.includes(curDesc[0])) {
            //add heading and content
            descHTML += '<div><h5>' + curDesc[0] + '</h5><p>' + curDesc[1] + '</p></div>';
        }
    }
    descHTML += '</div>';
    return descHTML;
}

//gets the HTML for a calendar where dates in periods are highlighted
function getCalendarHTML(periods) {

    //TODO: put error checking on period length

    //initialise array of classnames for each date
    var dateClassNames = [];
    var len = 32;
    for (var i = 0; i < len; i++) {
        dateClassNames.push("");
    }

    var startPeriod;
    var endPeriod;
    for (var i in periods) {
        startPeriod = new Date(periods[i].startPeriod);
        var startDate = startPeriod.getDate();
        dateClassNames[startDate] += "active-start ";

        endPeriod = new Date(periods[i].endPeriod);
        var endDate = endPeriod.getDate();
        dateClassNames[endDate] += "active-end ";

        for (var j = startDate; j < endDate + 1; j++) {
            dateClassNames[j] += "active ";
        }
    }

    //get the starting day of the month and the length of month
    var curMonth = startPeriod.toLocaleString('default', {
        month: 'long'
    });

    console.log(startPeriod.getMonth());
    var monthOffset = (new Date(startPeriod.getFullYear(), startPeriod.getMonth(), 1).getDay()+6)%7;
    var daysInMonth = new Date(startPeriod.getFullYear(), startPeriod.getMonth()+1, 0).getDate();

    //start HTML with month and year
    var scheduleHTML = `
    <div class="month">
      <ul>
        <li>` + curMonth + `<br><span style="font-size:18px">` + startPeriod.getFullYear() + `</span></li>
      </ul>
    </div>
    <ul class="weekdays">
        <li>Mo</li>
        <li>Tu</li>
        <li>We</li>
        <li>Th</li>
        <li>Fr</li>
        <li>Sa</li>
        <li>Su</li>
    </ul>

    <ul class="days">`;

    //for each cell in date grid, 6 rows, 7 days, 6*7=42
    for (var i = 1; i <= 42; i++) {
        var date = i - monthOffset;
        //if date is more than 0 and less than days in month
        if (0 < date && date <= daysInMonth) {
            scheduleHTML += '<li class="' + dateClassNames[date] + '">' + (date) + '</li>';
        } else {
            scheduleHTML += '<li></li>';
        }
    }

    //close list of dates and div
    scheduleHTML += '</ul>';

    return scheduleHTML;
}

//returns HTML for multiple calendars if periods are across several months
function getMultiCalendarHTML(periods) {
    //TODO: decide on clearer naming
    scheduleHTML = '';

    //check if period is in same month as previous. if not display current group and start new one. add curPeri
    var curPeriodGroup = [periods[0]];
    for (var i = 1; i < periods.length; i++) {
        var curPeriod = periods[i];
        if (new Date(curPeriod.startPeriod).getMonth() != new Date(periods[i - 1].startPeriod).getMonth()) {
            scheduleHTML += getCalendarHTML(curPeriodGroup) + '<hr>';
            curPeriodGroup = [];
        }
        //add curPeriod to periodGroup
        curPeriodGroup.push(curPeriod);
    }
    scheduleHTML += getCalendarHTML(curPeriodGroup) + '<hr></div>';
    return scheduleHTML;
}

//gets the HTML for displaying a list of work periods
function getScheduleHTML(periods) {

    //TODO: error checking periods.length

    //open div
    var scheduleHTML = '<div>';

    //initialise curPeriod
    var curPeriod = periods[0];

    for (var i in periods) {
        curPeriod = periods[i];

        //get start and end period
        var curStartPeriod = new Date(curPeriod.startPeriod);
        var curEndPeriod = new Date(curPeriod.endPeriod);

        //TODO: handle different types of period. e.g. 06:00 - 22:00 on multiple days in a row
        //if start and end on same date just display "date /n startTime - endTime"
        if (getDateString(curStartPeriod) == getDateString(curEndPeriod)) {
            scheduleHTML += '<h5 class="time-slot">' + getDateString(curStartPeriod) + `</h5>
                    <div class="event">
                        <h5>` + getTimeString(curStartPeriod) + ' - ' + getTimeString(curEndPeriod) + `</h5>
                    </div>`;
        } else {
            //if start and end date different display "startDate - endDate /n startDate startTime - endDate endTime"
            scheduleHTML += '<h5 class="time-slot">' + getDateString(curStartPeriod) + ' - ' + getDateString(curEndPeriod) + `</h5>
                <div class="event">
                    <h5>` + getDateString(curStartPeriod) + ' ' + getTimeString(curStartPeriod) + ' - ' + getDateString(curEndPeriod) + ' ' + getTimeString(curEndPeriod) + `</h5>
                </div>`;
        }

    }
    //close div
    scheduleHTML += '</div>';

    return scheduleHTML;
}

//gets the HTML for displaying the status of lanes during roadworks
function getLanesHTML(lanes) {

    //open div, add heading, open row
    lanesHTML = '<hr><div><h3>Lanes</h3><table><tr>';

    //for each lane
    for (var i in lanes) {
        var curLane = lanes[i];

        //get correct colour based on laneStatus
        var className = "";
        var status = ""
        switch (curLane.laneStatus) {
            case 'HARD_SHOULDER_RUNNING':
            case 'NORMAL':
                status = "Normal";
                className = 'green';
                break;
            case 'UNKNOWN':
            case 'AFFECTED':
                status = "Affected";
                className = 'yellow';
                break;
            case 'CLOSED':
                status = "Closed";
                className = 'red';
                break;
        }

        //add html to set up column, create div with relevant class name and display information
        lanesHTML += `
            <td>
                <div class = "lane ` + className + `">
                    <h5> ` + curLane.laneName + ` </h5>
                    <p> ` + status + ` </p>
                </div>
            </td>
            `;
    }

    //close row and div
    lanesHTML = lanesHTML.concat('</tr></table></div>');

    return lanesHTML;
}

//sets the contents of an InfoControl to display relvant information about a selected roadwork
function updateInfoBox(marker) {

    console.log("New Marker-----------------------------");

    //set headings which are returned by getDescriptionHTML
    var descriptionFilter = ["Location ", "Reason ", "Schedule ", "Period "];

    var periods = marker.properties.periods;
    console.log(periods);
    //TODO: make all html variables one string?
    var scheduleHTML = '';

    //if there are periods
    if (periods.length != 1) {

        //TODO: move into scheduleHTML
        //initialise ScheduleHTML
        scheduleHTML = '<hr><div><h3>Schedule</h3>';

        //remove Schedule and Periods from description as they are displayed as a calander and schedule instead
        descriptionFilter = ["Location ", "Reason "];

        scheduleHTML += getMultiCalendarHTML(periods);

        //add calendar of last period group, add hr, add schedule, close div

        scheduleHTML += getScheduleHTML(periods);
        scheduleHTML += '</div>';
    }

    //get description and relevant HTML
    var desc = marker.properties.description;
    console.log(desc);
    var descHTML = getDescriptionHTML(desc, descriptionFilter);

    //get lanes and relevantHTML
    var lanes = marker.properties.lanes;
    console.log(lanes);
    var lanesHTML = "";
    if (lanes.length != 0) {
        lanesHTML = getLanesHTML(lanes);
    }

    //get infoBox element, change innerHTML and show it
    document.getElementById('infoBox').innerHTML = descHTML + scheduleHTML + lanesHTML;
    document.getElementById('infoBox').style.display = 'block';
}
