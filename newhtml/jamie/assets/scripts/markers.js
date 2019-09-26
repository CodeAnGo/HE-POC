//TODO: decide on feature/ marker naming convention
//TODO: change functions to take set of data and filter out not relevant items, then create function to convert to featureCollection

//takes in a featureCollection of markers with desription, fullClosure, fullClosure, lanes and periods properties and displays them on the map. Also adds clickEvent listener
function displayMarkers(featureCollection) {
    // add markers to map
    //TODO: remove inline function
    featureCollection.forEach(function(marker) {
        // create a HTML element for each feature
        var el = document.createElement("div");
        switch (marker.properties.fullClosure) {
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
        markers.push(new mapboxgl.Marker(el).setLngLat(marker.geometry.coordinates).addTo(map));
    });
}

//adds newFeature to the end of featureCollection and returns new collection
function addFeature(featureCollection, newFeature) {
    
    // push new feature to the collection
    featureCollection.push({
        "type": "Feature",
        "geometry": {
            "type": "Point",
            "coordinates": [newFeature.longitude, newFeature.latitude]
        },
        "properties": {
            "description": newFeature.formatDesc,
            "fullClosure": newFeature.fullClosure,
            "lanes": newFeature.eventLanes,
            "periods": newFeature.periods
        }
    });
    return featureCollection;
}

//gets all roadworks where roadwork.roadName == step.name, is active on the selected date and the latitude/longitude is close to an intersection (rough on step roadwork detection)
function getFeaturesOnRoad(step) {

    //remove currently displayed markers
    removeMarkers();

    var featureCollection = []; // Initialize empty collection

    //get the date element
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
                        var bound = 0.05;
                        if (data[itemIndex].longitude - bound < step.intersections[intersectionIndex].location[0] && step.intersections[intersectionIndex].location[0] < data[itemIndex].longitude + bound &&
                            data[itemIndex].latitude - bound < step.intersections[intersectionIndex].location[1] && step.intersections[intersectionIndex].location[1] < data[itemIndex].latitude + bound) {
                            featureCollection = addFeature(featureCollection, data[itemIndex]);
                        }
                    }

                }
            }
        }
    }
    return featureCollection;

}

//gets roadworks on each step in route and displays on the map
function displayFeaturesOnRoute(e) {
    featureCollection = [];
    //get steps
    steps = e.route[0].legs[0].steps;
    //for each step get the road name. If not null get features on that road
    for (var i in steps) {
        var curStepName = steps[i].name;
        if (curStepName != "") {
            featureCollection = featureCollection.concat(getFeaturesOnRoad(steps[i]));
        }
    }
    displayMarkers(featureCollection);
}

//gets all current roadworks
function displayDateFeatures() {

    removeMarkers();

    var featureCollection = []; // Initialize empty collection

    var date = document.getElementById('date').valueAsNumber;

    // for every item object within data
    for (var itemIndex in data) {
        //if the currently selected date is within one of the periods add feature to feature collection
        for (var periodIndex in data[itemIndex].periods) {
            if (data[itemIndex].periods[periodIndex].startPeriod < date && date < data[itemIndex].periods[periodIndex].endPeriod) {
                featureCollection = addFeature(featureCollection, data[itemIndex]);
            }
        }
    }

    displayMarkers(featureCollection);
}

//removes all the markers from the map so new selection can be applied
function removeMarkers() {
    //remove current markers
    markers.forEach(function(marker) {
        marker.remove();
    });
    markers = [];
}
