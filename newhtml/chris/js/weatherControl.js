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

var weatherControl = null;
mapDirections.on('route', function(e) {
	if (map.getSource('weatherData'))
		map.removeSource('weatherData');

	var route0 = e['route'][0];
	var route1 = e['route'][1];
	var routes = [route0, route1];

	var features = [];
	//routes.forEach(function(route) {
		route0.legs[0].steps.forEach(function(step) {
			features.push({
				"type": "Feature",
				"geometry": {
					"type": "Point",
					"coordinates": [step.intersections[0].location[0], step.intersections[0].location[1]]
				},
				"properties": {
					"distance": step.distance / 1600
				}
			});
		});
	//});
	map.addSource('weatherData', {
		"type": "geojson",
		"data": {
			"type": "FeatureCollection",
			"features": features
		}
	});
	//weatherControl = new WeatherControl();
	//map.addControl(weatherControl, 'bottom-left');
	features.forEach(function(feature) {
		var latlong = feature.geometry.coordinates[0] + ',' + feature.geometry.coordinates[1];
		getWeather(latlong, document.getElementById('dateselect').value, feature.properties.distance);
	});

	//Do something with time value
	//May be out of sync as it waits for json to load from api
});
/*
mapDirections.on('clear', function() {
	map.removeControl(weatherControl);
	weatherControl = null;
	if (map.getLayer('weather'))
		map.removeLayer('weather');
});

function weatherLayer() {
	var weatherbox = document.getElementById("weather");
	if (weatherbox.checked) {
		map.addLayer({
			"id": "weather",
			"type": "circle",
			"source": "weatherData",
			"paint": {
				"circle-radius": 10,
				"circle-color": "#111111",
				"circle-opacity": 0.6
			},
		});
	} else {
		map.removeLayer('weather');
	}
}

class WeatherInfoControl {
	constructor(data) {
		this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl controlbox';
        this._container.innerHTML = data;
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
*/

var time = 0;
var apiKey = '758eced60b414375a78102504192609';
function getWeather(latlong, date, distance) {
	var url = 'http://api.worldweatheronline.com/premium/v1/weather.ashx?q=' + latlong + '&format=json&num_of_days=' + 1 + '&date=' + date + '&key=' + apiKey;
	var req = new XMLHttpRequest();
	req.responseType = 'json';
	//req.open('GET', url, true);
	req.onload = function() {
		var data = req.response;
		console.log(data);
		if (data.data.hasOwnProperty('current_condition')) {
			if (adverse(data)) {
				//Adverse weather adds some time per mile
				time += (10 * distance) / 60;
			}
		} else {
			console.log(latlong);
		}
	};
	req.send();
}

function adverse(data) {
	console.log('precip: ' + data.data.current_condition[0].precipMM);
	console.log('vis: ' + data.data.current_condition[0].visibility);
	console.log('vis miles: ' + data.data.current_condition[0].visibilityMiles);
	console.log('snow: ' + data.data.weather[0].totalSnow_cm);
	console.log('');
	if (data.data.current_condition[0].precipMM > 2.5 || data.data.current_condition[0].visibilityMiles == 6)
		return true;
	return false;
}

function getWeatherDataFromFiles() {
    weatherData = [weather0, weather1, weather2, weather3, weather4, weather5, weather6, weather7, weather8, weather9, weather10];
    console.log(weatherData);
}
