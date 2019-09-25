class RouteRoadworksControl {
	constructor(works) {
		var html = '';
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl controlbox';
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

//check if this is called before other route function
mapDirections.on('route', function(e) {
	//populate control with roadworks from filter
	
	map.addControl(new RouteRoadworksControl(), 'top-left');
});