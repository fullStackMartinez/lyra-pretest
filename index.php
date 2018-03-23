<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--jquery script-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!--Bootstrap CDN-->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
				integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<title>How far is your trip?</title>
		<!--Adding Google Map-->
		<style>
			#map {
				height: 300px;
				width: 90%;
			}
		</style>
	</head>
	<body>
		<!--header with title and brief web page description-->
		<header class="container">
			<h1>How Far Is Your Trip?</h1>
			<p>This page is intended to take two points and calculate the distance and travel time between them using
				Google Maps.</p>
		</header>
		<div class="container">
			<div class="row mt-3">
				<div class="col-md-6">
					<div id="map"></div>
				</div>
				<div class="col-md-6">
					<!--Form for entering two user points-->
					<form id="distance">
						<div class="form-group">
							<label for="starting_point">Origin</label>
							<input class="form-control" id="starting_point" placeholder="Where are you coming from?">
							<input id="origin" type="hidden" name="origin" required/>
						</div>
						<div class="form-group">
							<label for="ending_point">Destination</label>
							<input class="form-control" id="ending_point" placeholder="What is your destination?">
							<input id="destination" type="hidden" name="destination" required/>
						</div>
						<input type="submit" value="calculate" class="btn btn-primary"/>
					</form>
					<!--list of results, distance and trip duration-->
					<div id="results">
						<ul class="list-group">
							<li>distance : <span id="in_mile"></span> miles</li>
							<li>duration : <span id="duration_text"></span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!--initializing Map options including center point and initial zoom level-->

		<script>
			function initMap() {
				var center = {lat: 35.0844, lng: -106.6504};
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 13,
					center: center
				});

				//Attempt at using Google Geocoder for visibly showing location

				var geocoder = new google.maps.Geocoder();

				document.getElementById('submit').addEventListener('click', function() {
					geocodeAddress(geocoder, map);
				});
			}

			//Attempt at making a marker show up where origin/destinations were

			function geocodeAddress(geocoder, resultsMap) {
				var address = document.getElementById('address').value;
				geocoder.geocode({'address': address}, function(results, status) {
					if(status === 'OK') {
						resultsMap.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: resultsMap,
							position: results[0].geometry.location
						});
					} else {
						alert('Geocode was not successful for the following reason: ' + status);
					}
				});
			}
		</script>

		<!--Function for adding Autocomplete features-->

		<script>
			$(function() {
				google.maps.event.addDomListener(window, 'load', function() {
					var starting_point = new google.maps.places.Autocomplete(document.getElementById('starting_point'));
					var ending_point = new google.maps.places.Autocomplete(document.getElementById('ending_point'));

					//Using addListener event in order to set up function to get distance between points

					google.maps.event.addListener(starting_point, 'place_changed', function() {
						var start = starting_point.getPlace();
						var from_address = start.formatted_address;
						$('#origin').val(from_address);
					});
					google.maps.event.addListener(ending_point, 'place_changed', function() {
						var end = ending_point.getPlace();
						var to_address = end.formatted_address;
						$('#destination').val(to_address);
					});

					/*var marker = new google.maps.Marker({
						position: starting_point,
						map: map,
						title: 'Hello World!'
					});*/
				});

				//Function to calculate the distance between locations

				function calculateDistance() {
					var origin = $('#origin').val();
					var destination = $('#destination').val();
					var service = new google.maps.DistanceMatrixService();
					service.getDistanceMatrix(
						{
							origins: [origin],
							destinations: [destination],
							travelMode: google.maps.TravelMode.DRIVING,
							unitSystem: google.maps.UnitSystem.IMPERIAL,
						}, callback);
				}

				//Function to get back results and insert them into the ul we made up top

				function callback(response, status) {
					if(status != google.maps.DistanceMatrixStatus.OK) {
						$('#result').html(err);
					} else {
						var origin = response.originAddresses[0];
						var destination = response.destinationAddresses[0];
						if(response.rows[0].elements[0].status === "ZERO_RESULTS") {
							$('#results').html("Sorry, but your search came up with no results. Please try again.")
						} else {
							var distance = response.rows[0].elements[0].distance;
							var duration = response.rows[0].elements[0].duration;
							var distance_in_mile = distance.value / 1609.34;
							var duration_text = duration.text;
							var duration_value = duration.value;
							$('#in_mile').text(distance_in_mile.toFixed(2));
							$('#duration_text').text(duration_text);
							$('#duration_value').text(duration_value);
							$('#from').text(origin);
							$('#to').text(destination);
						}
					}
				}

				//Shows results for distance

				$('#distance').submit(function(e) {
					e.preventDefault();
					calculateDistance();
				});
			});
		</script>
		<script async defer
				  src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCObJ9LHdniD6gtg4QlT45KpWygYZ96PFA&callback=initMap">
		</script>
	</body>
</html>
