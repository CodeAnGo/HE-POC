
//input type="datetime-local" name="date" id="date" onchange="displayDateFeatures()">
class DateControl {

    onAdd(map) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl';
        this._container.innerHTML = '<input type="datetime-local" class="date" id="date" onchange="displayDateFeatures()">';
        return this._container;
    }

    onRemove() {
        this._container.parentNode.removeChild(this._container);
        this._map = undefined;
    }
}
