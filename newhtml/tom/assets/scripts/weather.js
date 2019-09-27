var testLatLong = [52.56,-1.47];
var testApiCallString = 'http://api.worldweatheronline.com/premium/v1/past-weather.ashx?format=json&num_of_days=1&date=2019-03-04&tp=24&key=758eced60b414375a78102504192609&q=52.56,-1.47';


var apiKey = '758eced60b414375a78102504192609';

//gets the weather at latitude and longitude give on 03/03/2019 (the day of storm freya) from the API and stores it in localStorage
function getWeatherAtPointAPICall(latlong) {
    var url = 'http://api.worldweatheronline.com/premium/v1/past-weather.ashx?q=' + latlong + '&format=json&num_of_days=1&date=2019-03-04&tp=24&key=' + apiKey;
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
        getWeatherAtPointAPICall(latLong);
		//console.log('API call would be made');
    }
    var weather = JSON.parse(localStorage.getItem(latLong));
    return weather;
}

//returns true if weather is adverse based on rainfall
//TODO: make function
function isAdverseWeather(weather) {

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
	if (weather.hourly[0].precipMM > 7.5){
		return true;
	}

	//snow not currently used
	/*if (weather.totalSnow_cm > 0) {
		return false
	}*/
    return false;
}

//gets latitude and longitude points along route and distance (in m) of assosciated route segment to get the weather on
//TODO: divide up route more evenly than intersections on steps
function getWeatherPointDistsAlongRoute(steps) {
    var latLongDist = [];
    for (var i in steps) {
        var dist = steps[i].distance;
        var latLong = [steps[i].intersections[0].location[1], steps[i].intersections[0].location[1]];
        latLongDist.push([latLong, dist]);
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

    console.log('weather not retrieved at ' + notRetrieved + ' out of ' + latLongDist.length + ' points');
    console.log('delay due to weather: ' + delayDueToWeather + ' minutes');
    return delayDueToWeather;

}
