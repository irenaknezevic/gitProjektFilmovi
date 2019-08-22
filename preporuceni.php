<?php 
session_start();
if(!empty($_SESSION['ime']))
{
	if(!empty($_SESSION['movieWarning']))
	{
	?>
	    <script type="text/javascript">
	        alert("Film je već dodan u 'Moji filmovi'!");
	    </script>
	<?php
	unset($_SESSION['movieWarning']);
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Preporučeni filmovi</title>
    <script src="js/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body ng-app="filmovi-app">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid navbar-left">
			<h4><a href="filmovi.php" id="preporuke">Moji filmovi</a></h4>
		</div>
		<div class="container-fluid navbar-right">
			<h4 id="korisnik">
				<a id="korIme" href="profil.php">
		            <?php 
		                echo $_SESSION['ime'];
		            ?>
	            </a>
			</h4>
			<button class="btn btn-danger btn-s" id="odjava" onclick="funkcijaOdjava()">Odjava</button>
		</div>
	</div>
	<div class="container">
		<h1>Preporučeni filmovi</h1>
		<br>
		<input class="form-control col-lg-3 col-xs-3" ng-model="inputTekst" id="trazilica" type="text" placeholder="pretraži...">

		<div ng-controller="filmoviTabliceController">
			<naslovnica-film>
					<!-- direktiva za tablicu preporučenih filmova-->
			</naslovnica-film>
		</div>
		
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