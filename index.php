<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCObJ9LHdniD6gtg4QlT45KpWygYZ96PFA&libraries=places"></script>
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
		<form>
			<div class="form-group">
				<label for="formGroupExampleInput">Example label</label>
				<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
			</div>
			<div class="form-group">
				<label for="formGroupExampleInput2">Another label</label>
				<input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input">
			</div>
		</form>
		<script>
			function initMap(){
				var center = {lat: 35.0844, lng: -106.6504};
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 10,
					center: center
				});
			}
		</script>
		<script async defer
				  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCObJ9LHdniD6gtg4QlT45KpWygYZ96PFA&callback=initMap">
		</script>
	</body>
</html>
