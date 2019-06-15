<?php 
session_start();
if(!empty($_SESSION['ime']))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moji filmovi</title>
    <script src="js/angular.min.js"></script>
	<script src="js/angular-route.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body ng-app="filmovi-app">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid navbar-right">
			<h4 id="korisnik">
				<?php 
					echo $_SESSION['ime'];
				?>
			</h4>
			<button class="btn btn-danger btn-s" id="odjava" onclick="funkcijaOdjava()">Odjava</button>
		</div>
	</div>
	<div class="container">
		<h1>Moji filmovi</h1>
		<br>
		<input class="form-control col-lg-3 col-xs-3" ng-model="inputTekst" id="trazilica" type="text" placeholder="pretraži...">

		<div ng-controller="filmoviTabliceController">
			<select class="form-control col-lg-3 col-xs-3" id="mojSelekt" ng-model="filter_zanr" ng-change="mojaFunkcijaPretrage()">
				<option value="">žanr</option>
				<option value="action">akcijski</option>
				<option value="adventure">avanturistički</option>
				<option value="animation">animirani</option>
				<option value="biography">biografski</option>
				<option value="comedy">komedija</option>
				<option value="crime">kriminalistički</option>
				<option value="documentary">dokumentarni</option>
				<option value="drama">drama</option>
				<option value="family">obiteljski</option>
				<option value="fantasy">fantazija</option>
				<option value="history">povijesni</option>
				<option value="horror">horor</option>
				<option value="music">glazbeni</option>
				<option value="musical">mjuzikl</option>
				<option value="mystery">misterij</option>
				<option value="romance">romantični</option>
				<option value="sci-fi">znanstvena-fantastika</option>
				<option value="sport">sportski</option>
				<option value="thriller">triler</option>
				<option value="war">ratni</option>
				<option value="western">kaubojski</option>
			</select>

			<select class="form-control col-lg-3 col-xs-3" id="mojaOcjena" ng-model="filter_ocjena" ng-change="mojaFunkcijaPretrage()">
				<option value="">ocjena</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			

			<a href="javascript:GetModal('modals.php?modal_id=dodaj_film');" class="btn btn-primary" id="btn_dodaj" role="button"><i class="fas fa-plus"></i></a>

			<br>
			<br>
			<br>

			<naslovnica-film>
			
			</naslovnica-film>
		</div>
		

		<!-- <div id="table-scroll" >
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Naziv filma</th>
						<th>Godina</th>
						<th>Žanr</th>
						<th>Ocjena</th>
						<th></th>
						<th></th>
					</tr>
				</thead>

				<tbody ng-controller="filmoviTabliceController">
					<tr ng-repeat="oFilm in oFilmovi">
						<td>{{oFilm.film_id}}</td>
						<td>{{oFilm.naziv_filma}}</td>
						<td>{{oFilm.godina}}</td>
						<td>{{oFilm.zanr}}</td>
						<td>{{oFilm.moja_ocjena}}</td>	
						<td onclick="getFilmId()"><span class="glyphicon glyphicon-search" onclick="" aria-hidden="true"></span></td>
						<td onclick="getFilmId()"><span class="glyphicon glyphicon-trash" onclick="" aria-hidden="true"></span></td>		
					</tr>
				</tbody>
			</table>
		</div>
 -->

		<div class="modal" id="modals" tabindex="-1" role="dialog" aria-labelledby="" aria-hiddeen="true">
			<div class="modal-dialog">
				<div class="modal-content">
					
				</div>
			</div>
		</div>

	</div>

	<script type="text/javascript" src="js/globals.js"></script>
	<script type="text/javascript" src="js/app.js"></script>
<!-- 	<script type="text/javascript" src="js/filmovi.js"></script>
 -->	
</body>
</html>

<?php 
}
else
{
	header("Location: pocetna.php");
}
?>