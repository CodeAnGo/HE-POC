var mapDirections = new MapboxDirections({
    accessToken: mapboxgl.accessToken,
	profile: 'mapbox/driving',
	controls: {
		profileSwitcher: false
	},
	alternatives: true,
	interactive: false
});

map.addControl(mapDirections, 'top-left');

//CODE FOR REMOVING NON_RELEVANT POINTS-----------------------ADD HERE LUKE
//----------------------------------------------------------
//----------------------------------------------------------
//----------------------------------------------------------


var directionMarkers = null;
mapDirections.on('route', function(e) {

    //bring markers to front
	map.moveLayer('roadworks');

	directionMarkers = [];
    //decode is to get route geometry. Use Luke's polylines decode function instead
	var geometry0 = decode(e['route'][0].geometry); //route
	var geometry1 = decode(e['route'][1].geometry); //alternate route
	var geometries = [geometry0, geometry1];

    //for each route
	geometries.forEach(function(geometry) {
        //for each roadwork
		roadworks.forEach(function(mark, i) {
            //code for detecting if roadwork is along route. Add Luke's on route detection instead
			for (j = 0; j < geometry.length; j++) {
				var d = Math.pow(mark.longitude - geometry[j].longitude, 2) + Math.pow(mark.latitude - geometry[j].latitude, 2);
				if (d <= 0.0000005 && !directionMarkers.includes(i)) {
					directionMarkers.push(i);
					break;
				}
			};
		});
	});

    //only displays roadworks on route
    //NEED TO ADD refreshMarkers() ---------------------------------------
	refreshMarkers();
});

mapDirections.on('clear', function(e) {
	directionMarkers = null;
	refreshMarkers();
});
//----------------------------------------------------------
//----------------------------------------------------------
//----------------------------------------------------------

//Copied
function decode(encoded){
    var points=[]
    var index = 0, len = encoded.length;
    var lat = 0, lng = 0;
    while (index < len) {
        var b, shift = 0, result = 0;
        do {
			b = encoded.charAt(index++).charCodeAt(0) - 63;
			result |= (b & 0x1f) << shift;
			shift += 5;
		} while (b >= 0x20);


		var dlat = ((result & 1) != 0 ? ~(result >> 1) : (result >> 1));
		lat += dlat;
		shift = 0;
		result = 0;
		do {
			b = encoded.charAt(index++).charCodeAt(0) - 63;
			result |= (b & 0x1f) << shift;
			shift += 5;
		} while (b >= 0x20);
		var dlng = ((result & 1) != 0 ? ~(result >> 1) : (result >> 1));
		lng += dlng;

		points.push({latitude:( lat / 1E5),longitude:( lng / 1E5)})
	}
	return points
}
