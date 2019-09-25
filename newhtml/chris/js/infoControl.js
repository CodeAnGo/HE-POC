class infoControl {
	constructor(desc, eventlanes) {
		var html = `
			<input type="button" class="closeButton" value="&#x2716;" onclick="removeInfo()" />
			<div class="table">
		`;
		desc.forEach(function(line) {
			var s = line.split(': ');
			html += `
				<div class="row">
					<div class="cell">` + s[0] + `</div>
					<div class="cell">` + s[1] + `</div>
				</div>
			`;
		});
		if (eventlanes.length != 0) {
			html += `
				</div>
				<div class="table fullwidth">
					<div class="row">
						<div class="cell road roadleftend"></div>
			`;
			eventlanes.forEach(function(lane) {
				var color;
				switch (lane.laneStatus) {
					case 'NORMAL':
						color = 'green';
						break;
					case 'AFFECTED':
						color = 'yellow';
						break;
					case 'CLOSED':
						color = 'red';
						break;
				}
				html += `
					<div class="cell road ` + color + `">` + lane.laneName + `<br />` + lane.laneStatus + `</div>
				`;
			});
			html += `
						<div class="cell road roadrightend"></div>
					</div>
				</div>
			`;
		}
		html += `
			</div>
		`;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl controlbox capheight';
		this._container.innerHTML = html;
	}
    onAdd(map) {
        this._map = map;
        return this._container;
    }
    onRemove() {
        this._container.parentNode.removeChild(this._container);
        this._map = undefined;
    }
}

var j = null;
var control = null;
map.on('click', 'roadworks', function(e) {
	var mark = e.features[0];
	var i = mark.properties.id;
	showInfoBox(i);
});

function showInfoBox(i) {
	var desc = roadworks[i].formatDesc;
	var lanes = roadworks[i].eventLanes;
	
	if (i == j) {
		removeInfo();
		j = null;
	}
	else {
		if (control != null)
			removeInfo();
		control = new infoControl(desc, lanes);
		map.addControl(control, 'bottom-right');
		j = i;
	}
}

function removeInfo() {
	map.removeControl(control);
	control = null;
}
