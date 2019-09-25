class DateControl {
    onAdd(map) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl controlbox table';
        this._container.innerHTML = `
			<div class="row">
				<div class="cell title pink">Date</div>
				<div class="cell"><input type="date" class="datetime" id="dateselect" onchange="dateFilter()"/></div>
			</div>
			<div class="row">
				<div class="cell title green">Time</div>
				<div class="cell"><input type="time" class="datetime" id="timeselect" onchange="dateFilter()"/></div>
			</div>
		`;
        return this._container;
    }
    onRemove() {
        this._container.parentNode.removeChild(this._container);
        this._map = undefined;
    }
}
map.addControl(new DateControl(), 'top-left');

datetimeMarkers = null;
function dateFilter() {
	var dateinput = document.getElementById('dateselect');
	var timeinput = document.getElementById('timeselect');
	if (dateinput.value == '' || timeinput.value == '')
		datetimeMarkers = null;
	else {
		datetimeMarkers = [];
		var date = dateinput.valueAsNumber + timeinput.valueAsNumber;
		roadworks.forEach(function(mark, i) {
			mark.periods.forEach(function(period) {
				if (date > period.startPeriod && date < period.endPeriod) {
					datetimeMarkers.push(i);
				}
			});
		});
	}
	refreshMarkers();
	//map.setFilter('weather', ['==', ['get', 'rain'], true, true, false]);
}
