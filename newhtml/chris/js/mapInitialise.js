mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jpc2RtIiwiYSI6ImNrMHFqdDk1bDA4cWozZ3BtYmxwdG12d2MifQ.OfD_9izCQMDuWrst98ZW_A';
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [-0.118092, 51.509865],
    zoom: 8
});

map.on('load', function() {
	var features = [{
		"type": "Feature",
		"geometry": {
			"type": "Point",
			"coordinates": [-0.118092, 51.509865]
		},
		"properties": {
			"id": -1,
		}
	}];
	roadworks.forEach(function(mark, i) {
		var color;
		switch (mark.fullClosure) {
			case false:
				features.push({
					"type": "Feature",
					"geometry": {
						"type": "Point",
						"coordinates": [mark.longitude, mark.latitude]
					},
					"properties": {
						"id": i,
						"color": "#fff700"
					}
				});
				break;
			case true:
				features.push({
					"type": "Feature",
					"geometry": {
						"type": "Point",
						"coordinates": [mark.longitude, mark.latitude]
					},
					"properties": {
						"id": i,
						"color": "#ff0000"
					}
				});
				break;
		}
	});
	map.addLayer({
		'id': 'roadworks',
		'type': 'circle',
		'source': {
			'type': 'geojson',
			'data': {
				"type": "FeatureCollection",
				"features": features
			}
		},
		'paint': {
			"circle-radius": [
				"interpolate", ["linear"], ["zoom"],
				5, 1,
				20, 30
			],
			"circle-color": ["get", "color"],
			"circle-opacity": ['case', ['==', ['get', 'id'], -1], 0, 0.7]
		}
	});
	var today = new Date();
	
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0');
	var yyyy = today.getFullYear();
	var dateinput = document.getElementById("dateselect");
	dateinput.value = yyyy + '-' + mm + '-' + dd;
	
	var hh = String(today.getHours()).padStart(2, '0');
	var mm = String(today.getMinutes()).padStart(2, '0');
	var timeinput = document.getElementById("timeselect");
	timeinput.value = hh + ':' + mm;
	
	dateFilter();
});

function getFilteredRoadworks() {
	var l;
	
	if (directionMarkers == null && datetimeMarkers == null && severityMarkers == null)
		l = [];
	else if (directionMarkers == null && datetimeMarkers == null)
		l = severityMarkers.slice();
	else if (directionMarkers == null && severityMarkers == null)
		l = datetimeMarkers.slice();
	else if (datetimeMarkers == null && severityMarkers == null)
		l = directionMarkers.slice();
	else if (severityMarkers == null)
		l = directionMarkers.filter(v => datetimeMarkers.includes(v));
	else if (directionMarkers == null)
		l = datetimeMarkers.filter(v => severityMarkers.includes(v));
	else if (datetimeMarkers == null)
		l = directionMarkers.filter(v => severityMarkers.includes(v));
	else {
		l = directionMarkers.filter(v => datetimeMarkers.includes(v));
		l = l.filter(v => severityMarkers.includes(v));
	}	
	return l;
}

function refreshMarkers() {
	var l = getFilteredRoadworks();
	l.push(-1);

	map.setFilter('roadworks', ['match', ['get', 'id'], l, true, false]);
	if (worksControl != null)
		showRouteRoadworks();
}
