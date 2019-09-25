class RouteRoadworksControl {
	constructor(works) {
		var html = '';
		works.forEach(function(i) {
			html += `
				<div class="row">
					<div class="cell"><div class="infoButton blue" onclick="showInfoBox(` + i + `)">Info</div></div>` + `
					<div class="cell">` + roadworks[i].formatDesc[0].split(': ')[1] + `</div>
				</div>
			`;
		});
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

var worksControl = null;
mapDirections.on('route', showRouteRoadworks);

function showRouteRoadworks() {
	var l = getFilteredRoadworks();
	if (worksControl != null)
		map.removeControl(worksControl);
	worksControl = new RouteRoadworksControl(l);
	map.addControl(worksControl, 'top-right');
}

mapDirections.on('clear', removeRouteRoadworks);

function removeRouteRoadworks() {
	map.removeControl(worksControl);
	worksControl = null;
}