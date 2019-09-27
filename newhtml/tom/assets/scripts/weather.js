var testLatLong  = [-1.47, 52.56];

var apiKey = '758eced60b414375a78102504192609';

//gets the weather at latitude and longitude give on 03/03/2019 (the day of storm freya) from the API and stores it in localStorage
function getWeatherAtPointAPICall(latlong) {
    var url = 'http://api.worldweatheronline.com/premium/v1/past-weather.ashx?q=' + latlong + '&format=json&num_of_days=' + 1 + '&date=2019-03-04&tp=24&key=' + apiKey;
    var req = new XMLHttpRequest();
    req.responseType = 'json';
    req.open('GET', url, true);
    req.onload = function() {
		console.log("API call made");
        var data = req.response;
		var dataString = JSON.stringify(data.data.weather[0]);
		localStorage.setItem(latlong, dataString);
    };
    req.send();
	return req;
}

function getWeatherAtPoint(latLong) {
	if (localStorage.getItem(latLong) === null) {
		getWeatherAtPointAPICall(latLong);
	}
	var weather = JSON.parse(localStorage.getItem(latLong));
	return weather;
}

function getWeatherAtPoints(latLongs){
	for (var i in latLongs){
		getWeatherAtPoint(latLongs[i]);
	}
}

//returns true if weather is adverse based on rainfall
//TODO: make function
function isAdverseWeather(weather){
	return false;
}

//gets latitude and longitude points along route and distance of assosciated route segment to get the weather on
//TODO: make function, call function
function getWeatherPointsAlongRoute(route){

}

//gets the delay in time from adverse weather detected on the route
//TODO: make function
function getDelayDueToWeather(route) {

}
