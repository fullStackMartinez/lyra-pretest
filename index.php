<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"
				integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<title>How far is your trip?</title>
		<style>
			#map {
				height: 300px;
				width: 75%;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>How Far Is Your Trip?</h1>
			<p>This page is intended to take two points and calculate the distance and travel duration between them using Google Maps.</p>
		</header>
		<div id="map"></div>
		<form id="distance">
			<div class="form-group">
				<label for="from_places">Origin</label>
				<input class="form-control" id="from_places" placeholder="Where are you coming from?">
				<input id="origin" type="hidden" name="origin" required/>
			</div>
			<div class="form-group">
				<label for="to_places">Destination</label>
				<input class="form-control" id="to_places" placeholder="What is your destination?">
				<input id="destination" type="hidden" name="destination" required/>
			</div>
			<input type="submit" value="calculate" class="btn btn-primary"/>
		</form>
		<div id="results">
			<ul class="list-group">
				<li>distance : <span id="in_mile"></span></li>
				<li>duration : <span id="duration"></span></li>
			</ul>
		</div>
		<script>
			function initMap(){
				var center = {lat: 35.0844, lng: -106.6504};
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 10,
					center: center
				});
			}
		</script>
	<script>
		$(function(){
			google.maps.event.addDomListener(window, 'load', function(){
				var from_places = new google.maps.places.Autocomplete(document.getElementById('from_places'));
				var to_places = new google.maps.places.Autocomplete(document.getElementById('to_places'));

				google.maps.event.addListener(from_places, 'place_changed', function() {
					var from_place = from_places.getPlace();
					var from_address = from_place.formatted_address;
					$('#origin').val(from_address);
				});
				google.maps.event.addListener(to_places, 'place_changed', function(){
					var to_place = to_places.getPlace();
					var to_address = to_place.formatted_address;
					$('#destination').val(to_address);
				});
			});
			//calculate the distance between locations
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
			//get results for distance
			function callback(response, status) {
				if (status != google.maps.DistanceMatrixStatus.OK) {
					$('#result').html(err);
				} else {
					var origin = response.originAddresses[0];
					var destination = response.destinationAddresses[0];
					if (response.rows[0].elements[0].status ==="ZERO_RESULTS") {
						$('#results').html("sorry, no results")
					} else {
						var distance = response.rows[0].elements[0].distance;
						var duration = response.rows[0].elements[0].duration;
						var distance_in_mile = distance.value / 1609.34;
					}
				}
			}
		})
	</script>
		<script async defer
				  src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCObJ9LHdniD6gtg4QlT45KpWygYZ96PFA&callback=initMap">
		</script>
	</body>
</html>
