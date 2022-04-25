<!DOCTYPE html>
<html lang="en">
<head>
<!-- scott campbell -> Air Pollution page
	CSE451
-->

	<title>campbest Air Pollution</title>
	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
	<script src="/cse451-tranhuq-web/airPollution/resources/views/airPollution.js"></script>
	<style>
#scott{
	height: 300px;
	width: 300px;
}
body  {
	width: 400;
	margin: auto;
}

	</style>
</head>
<body >
	<div class='d-flex justify-content-center'>
		<div >
			<h1>Air pollution in three cities (NO2)</h1>
			<div id='scott' >
				<canvas id='myChart' height="300"></canvas>
			</div>
	<form class='form'>
		<div class='city'>
			<label for='loc1'>Location</label>
			<input type='text' id='loc1' class='locs'></input>
		</div>
		<div class='city'>
			<label for='loc2'>Location</label>
			<input type='text' id='loc2' class='locs'></input>
		</div>
		<div class='city'>
			<label for='loc3'>Location</label>
			<input type='text' id='loc3' class='locs'></input>
		</div>
	</form>
		</div>
	</div>
</body>
</html>
