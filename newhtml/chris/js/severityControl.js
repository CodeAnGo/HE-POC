class SeverityControl {
    onAdd(map) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl controlbox table';
        this._container.innerHTML = `
			<div class="row">
				<div class="cell yellow"><div class="container"><input type="checkbox" id="open" onchange="severityFilter()" checked/><label for="open" class="checkmark"></span></div></div>
				<div class="cell"><label for="open">Roadworks</label></div>
			</div>
			<div class="row">
				<div class="cell red"><div class="container"><input type="checkbox" id="close" onchange="severityFilter()" checked/><label for="close" class="checkmark"></span></div></div>
				<div class="cell"><label for="close">Closed Roads</label></div>
			</div>
		`;
        return this._container;
    }
    onRemove() {
        this._container.parentNode.removeChild(this._container);
        this._map = undefined;
    }
}
map.addControl(new SeverityControl(), 'top-left');

var severityMarkers = null;
function severityFilter() {
	severityMarkers = [];
	var openbox = document.getElementById('open');
	var closebox = document.getElementById('close');
	roadworks.forEach(function(mark, i) {
		if (openbox.checked && mark.fullClosure == false)
			severityMarkers.push(i);
		if (closebox.checked && mark.fullClosure == true)
			severityMarkers.push(i);
	});
	refreshMarkers();
}