




function displayMarkers(featureCollection) {
    // add markers to map
    featureCollection.forEach(function(marker) {
        // create a HTML element for each feature
        var el = document.createElement("div");
        switch (marker.properties.severity) {
            case false:
                el.className = "marker marker-roadworks";
                break;
            case true:
                el.className = "marker marker-closed";
                break;
        }

        el.addEventListener('click', function(event) {
            updateInfoBox(marker);
        });


        // make a marker for each feature and add to the map
        markers.push(new mapboxgl.Marker(el)
            .setLngLat(marker.geometry.coordinates)
            //.setPopup(new mapboxgl.Popup({
            //        offset: 25
            //    }) // add popups
            //    .setHTML("<p>" + marker.properties.description + "</p>"))
            .addTo(map));
    });
}

function addFeatures(featureCollection, newFeature) {
    // push new feature to the collection

    featureCollection.push({
        "type": "Feature",
        "geometry": {
            "type": "Point",
            "coordinates": [newFeature.longitude, newFeature.latitude]
        },
        "properties": {
            "description": newFeature.formatDesc,
            "severity": newFeature.fullClosure,
            "fullClosure": newFeature.fullClosure,
            "lanes": newFeature.eventLanes,
            "periods": newFeature.periods
        }
    });
    return featureCollection;
}

function getFeaturesOnRoad(step) {

    removeMarkers();

    var featureCollection = []; // Initialize empty collection

    var date = document.getElementById('date').valueAsNumber;

    // for every item object within data
    for (var itemIndex in data) {
        //if on current date
        for (var periodIndex in data[itemIndex].periods) {
            if (data[itemIndex].periods[periodIndex].startPeriod < date && date < data[itemIndex].periods[periodIndex].endPeriod) {
                //if roadname matches
                if (step.name == data[itemIndex].roadName) {
                    //if feature on point
                    for (var intersectionIndex in step.intersections) {
                        //console.log(step.intersections[intersectionIndex].location[1]);
                        //console.log(data[itemIndex].longitude);
                        var bound = 0.05;
                        if (data[itemIndex].longitude - bound < step.intersections[intersectionIndex].location[0] && step.intersections[intersectionIndex].location[0] < data[itemIndex].longitude + bound &&
                            data[itemIndex].latitude - bound < step.intersections[intersectionIndex].location[1] && step.intersections[intersectionIndex].location[1] < data[itemIndex].latitude + bound) {
                            featureCollection = addFeatures(featureCollection, data[itemIndex]);
                        }
                    }

                }
            }
        }
    }
    return featureCollection;

}

function displayFeaturesOnRoute(e) {
    featureCollection = [];
    steps = e.route[0].legs[0].steps;
    for (var i in steps) {
        var curStepName = steps[i].name;
        if (curStepName != "") {
            featureCollection = featureCollection.concat(getFeaturesOnRoad(steps[i]));
        }
    }
    displayMarkers(featureCollection);
}

function displayDateFeatures() {

    removeMarkers();

    var featureCollection = []; // Initialize empty collection

    var date = document.getElementById('date').valueAsNumber;

    // for every item object within data
    for (var itemIndex in data) {
        //if on current date
        for (var periodIndex in data[itemIndex].periods) {
            if (data[itemIndex].periods[periodIndex].startPeriod < date && date < data[itemIndex].periods[periodIndex].endPeriod) {
                featureCollection = addFeatures(featureCollection, data[itemIndex]);
            }
        }
    }

    displayMarkers(featureCollection);
}

function removeMarkers() {
    //remove current markers
    markers.forEach(function(marker) {
        marker.remove();
    });
    markers = [];
}
