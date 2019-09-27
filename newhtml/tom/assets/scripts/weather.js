var testLatLong = [52.56,-1.47];
var testApiCallString = 'http://api.worldweatheronline.com/premium/v1/past-weather.ashx?format=json&num_of_days=1&date=2019-06-04&tp=24&key=758eced60b414375a78102504192609&q=52.56,-1.47';

var date = '2019-06-04';

var apiKey = '758eced60b414375a78102504192609';

//gets the weather at latitude and longitude give on 03/03/2019 (the day of storm freya) from the API and stores it in localStorage
function getWeatherAtPointAPICall(latlong) {
    var url = 'http://api.worldweatheronline.com/premium/v1/past-weather.ashx?q=' + latlong + '&format=json&num_of_days=1&date=' + date + '&tp=24&key=' + apiKey;
    var req = new XMLHttpRequest();
    req.responseType = 'json';
    req.open('GET', url, true);
    req.onload = function() {

        var data = req.response;
        if (data.data.hasOwnProperty('weather')) {
            var dataString = JSON.stringify(data.data.weather[0]);
            localStorage.setItem(latlong, dataString);
            console.log("API call made and succeeded");
        } else {
            console.log("API call made and failed");
        }
    };
    req.send();
    return req;
}

function getWeatherAtPoint(latLong) {
    if (localStorage.getItem(latLong) === null) {
		//UNCOMMENT THE FOLLOWING LINE TO GET NEW DATA. DISABLED TO STOP HITTING API REQUEST LIMIT
		//-------------------------------------------------------------------
        //getWeatherAtPointAPICall(latLong + '-' + date);
		console.log('API call would be made');
    }
    var weather = JSON.parse(localStorage.getItem(latLong));
    return weather;
}

//returns true if weather is adverse based on rainfall
function isAdverseWeather(weather) {

	console.log('precipMM: ' + weather.hourly[0].precipMM + '\tvisibility: ' + weather.hourly[0].visibility);

	//visibility: https://www.semanticscholar.org/paper/Analysis-of-the-atmospheric-visibility-Restoration-Deshpande/662237bb893d2b50a728751880f20cf1f8225aef/figure/0
	//1: Dense fog
	//2: Thick fog
	//3: Moderate fog
	//4: Light fog
	//5: Thin fog
	if (weather.hourly[0].visibility <= 4){
		return true;
	}

	//precipitation mm: http://www.officialgazette.gov.ph/images/uploads/rainfall-english.jpg
	//Torrential:	More than 30mm
	//Intense:		15-30mm
	//Heavy:		7.5-15mm
	//Moderate:		2.5-7.5mm
	if (weather.hourly[0].precipMM > 5){
		return true;
	}

	//snow not currently used
	/*if (weather.totalSnow_cm > 0) {
		return false
	}*/
    return false;
}

//gets latitude and longitude points along route and distance (in m) of assosciated route segment to get the weather on
function getWeatherPointDistsAlongRoute(steps) {

	var distanceToPoint = 20000;//distance in metres between weather checking point
	var curDistance = 0;//current distance. Resets to zero every new point

	var latLongDist = [];

	for (var i in steps) {

		//assume intersections are evenly split along step
		var stepDist = steps[i].distance;
		var intersectionDistance = stepDist/steps[i].intersections.length;

		for (var j in steps[i].intersections){
			curDistance += intersectionDistance;
			//if you have traveled more than distanceToPoint from last point then add current intersection to latLongDist
			if (curDistance > distanceToPoint){
				var latLong = [steps[i].intersections[j].location[1], steps[i].intersections[j].location[0]];
				var dist = curDistance;
				latLongDist.push([latLong, dist]);
				curDistance = 0;
			}
		}
	}

    return latLongDist;
}

//gets the delay in time from adverse weather detected on the route
function getDelayDueToWeather(steps) {
	console.log(steps);
    var notRetrieved = 0;
    var latLongDist = getWeatherPointDistsAlongRoute(steps);

    var distAdverseMetres = 0;

    for (var i in latLongDist) {
		displayLatLongMarker(latLongDist[i][0]);

        var weather = getWeatherAtPoint(latLongDist[i][0]);
        if (weather != null) {
            if (isAdverseWeather(weather)) {
                distAdverseMetres += latLongDist[i][1];
            }
        } else {
            notRetrieved += 1;
        }
    }

    var delayPerMetre = (10 / 60) / 1600; //10 seconds/mile to minutes/metre
    var delayDueToWeather = distAdverseMetres * delayPerMetre;

    console.log('weather retrieved at ' + (latLongDist.length-notRetrieved) + ' out of ' + latLongDist.length + ' points');
    console.log('delay due to weather: ' + delayDueToWeather + ' minutes');
    return delayDueToWeather;

}
