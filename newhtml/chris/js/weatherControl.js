class WeatherControl {
    onAdd(map) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl controlbox';
        this._container.innerHTML = `
			<div class="row">
				<div class="cell blue"><div class="container"><input type="checkbox" id="weather" onchange="weatherLayer()"/><label for="weather" class="checkmark"></span></div></div>
				<div class="cell"><label for="weather">Weather</label></div>
			</div>
		`;
        return this._container;
    }
    onRemove() {
        this._container.parentNode.removeChild(this._container);
        this._map = undefined;
    }
}
map.addControl(new WeatherControl(), 'top-right');

function weatherLayer() {
	var weatherbox = document.getElementById("weather");
	if (weatherbox.checked) {
		map.addLayer({
			"id": "weather",
			"type": "circle",
			"source": "weatherData",
			"paint": {
				"circle-radius": 20,
				"circle-color": "#0000ff",
				"circle-opacity": 0.4
			},
		});
	} else {
		map.removeLayer('weather');
	}
}

map.on('load', function() {
	//GET BETTER WEATHER DATA (CURRENT)
	var features = [];
	weather.forEach(function(location) {
		
		features.push({
			"type": "Feature",
			"geometry": {
				"type": "Point",
				"coordinates": [location.city.coord.lon, location.city.coord.lat]
			},
			"properties": {
				"datetime": ,
				"rain": 
			}
		});
	});
	map.addSource('weatherData', {
		"type": "geojson",
		"data": {
			"type": "FeatureCollection",
			"features": features
		}
	});
});