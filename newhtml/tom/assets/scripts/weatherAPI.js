var apiKey = '758eced60b414375a78102504192609';

function getWeather(latlong, date) {
	var url = 'http://api.worldweatheronline.com/premium/v1/weather.ashx?q=' + latlong + '&format=json&num_of_days=' + 3 + '&date=' + date + '&key=' + apiKey;
	var req = new XMLHttpRequest();
	req.responseType = 'json';
	req.open('GET', url, true);
	req.onload = function() {
		var data = req.response;
		console.log(data);
	};
	req.send();
}
