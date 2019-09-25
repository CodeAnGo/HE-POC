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
            descHTML = descHTML.concat('<div><h5>' + curDesc[0] + '</h5><p>' + curDesc[1] + '</p></div>');
        }
    }
    descHTML = descHTML.concat('</div>');
    return descHTML;
}

//gets the HTML for a calendar where dates in periods are highlighted
function getCalendarHTML(periods) {

    //TODO: put error checking on period length

    //TODO: change to array of class strings, gets rid of if statements later on
    var activeDates = [];
    var activeStartDates = [];
    var activeEndDates = [];

    //initialise start + endPeriod as they are used later
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

    //get the starting day of the month and the length of month
    var curMonth = startPeriod.toLocaleString('default', {
        month: 'long'
    });
    var monthOffset = new Date(startPeriod.getFullYear(), startPeriod.getMonth(), 1).getDay() + 6;
    var daysInMonth = new Date(startPeriod.getFullYear(), startPeriod.getMonth(), 0).getDate();

    //start HTML with month and year
    var scheduleHTML = `
    <div class="month">
      <ul>
        <li>` + curMonth + `<br><span style="font-size:18px">` + startPeriod.getFullYear() + `</span></li>
      </ul>
    </div>`;

    //day labels, open date section of calendar
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

    //for each cell in date grid, 6 rows, 7 days, 6*7=42
    for (var i = 1; i <= 43; i++) {
        //if date is more than 0 and less than days in month
        if (0 < i - monthOffset && i - monthOffset < daysInMonth) {

            //TODO: tidy by defining class strings instead of different arrays
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

    //close list of dates and div
    scheduleHTML = scheduleHTML.concat('</ul></div>');

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

        //if start and end on same date just display "date /n startTime - endTime"
        if (getDateString(curStartPeriod) == getDateString(curEndPeriod)) {
                scheduleHTML = scheduleHTML.concat('<h5 class="time-slot">' + getDateString(curStartPeriod) + `</h5>
                    <div class="event">
                        <h5>` + getTimeString(curStartPeriod) + ' - ' + getTimeString(curEndPeriod) + `</h5>
                    </div>`);
        } else {
            //if start and end date different display "startDate - endDate /n startDate startTime - endDate endTime"
            scheduleHTML = scheduleHTML.concat('<h5 class="time-slot">' + getDateString(curStartPeriod) + ' - ' + getDateString(curEndPeriod) + `</h5>
                <div class="event">
                    <h5>` + getDateString(curStartPeriod) + ' ' + getTimeString(curStartPeriod) + ' - ' + getDateString(curEndPeriod) + ' ' + getTimeString(curEndPeriod) + `</h5>
                </div>`);
        }

    }
    //close div
    scheduleHTML = scheduleHTML.concat('</div>');

    return scheduleHTML;
}

//gets the HTML for displaying the status of lanes during roadworks
function getLanesHTML(lanes) {

    //open div, add heading, open row
    lanesHTML = '<hr><div><h3>Lanes</h3><div class="lanes row">';

    //TODO: split columns evenly not using hacky bootstrap
    //bootstrap uses 12 columns. To get width divide 12 by number of lanes
    var colWidth = 12 / lanes.length;
    //catch is divided by 5
    if (lanes.length == 5) {
        colWidth = 2;
    }

    //for each lane
    for (var i in lanes) {
        var curLane = lanes[i];
        //TODO: set class beforehand instead of using laneStatus as className
        //add html to set up column, create div with relevant class name and display information
        lanesHTML = lanesHTML.concat(`
            <div class="col-lg-` + colWidth + `">
                <div class = "lane ` + curLane.laneStatus + `">
                    <h5> ` + curLane.laneName + ` </h5>
                    <p> ` + curLane.laneStatus + ` </p>
                </div>
            </div>
            `);
    }

    //close row and div
    lanesHTML = lanesHTML.concat('</div></div>');

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
        scheduleHTML = '<hr><div><h3>Schedule</h3>'

        //remove Schedule and Periods from description as they are displayed as a calander and schedule instead
        descriptionFilter = ["Location ", "Reason "];

        //TODO: move logic to getCalendarHTML
        //check if period is in same month as previous. If it is it add it to period group, if not display current group and start new one
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

        //add calendar of last period group, add hr, add schedule, close div
        scheduleHTML = scheduleHTML.concat(getCalendarHTML(curPeriods) + '<hr>');
        scheduleHTML = scheduleHTML.concat(getScheduleHTML(periods));
        scheduleHTML = scheduleHTML.concat('</div>');
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
