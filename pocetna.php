<?php 

session_start();
if(!empty($_SESSION['usernameTaken']))
{
?>
	<script type="text/javascript">
		alert('Korisničko ime je zauzeto!');
	</script>
<?php
	unset($_SESSION['usernameTaken']);
}

if(!empty($_SESSION['authFail']))
{
?>
	<script type="text/javascript">
		alert("Pogrešno korisničko ime ili lozinka, pokušajte ponovo!");
	</script>
<?php
	unset($_SESSION['authFail']);
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moji filmovi</title>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="loginbox">
		<img src="img/korisnik.png" class="slika">
		<form id="formaPrijava" class="form-horizontal" action="autentifikacija.php" method="POST">
			<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Korisničko ime:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="korime" required></div>
			</div>
			
			<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Lozinka:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="password" name="lozinka" required></div>
			</div>

			<div class="modal-footer">
						<button id="loginButton" type="submit" class="btn btn-danger btn-s">Prijava</button>
		</form>
						<button type="button" class="btn btn-primary btn-s" onclick="GetModal('modals.php?modal_id=novi_korisnik')">Registriraj se</button>
			</div>
		
	</div>

	<div class="modal" id="modals" tabindex="-1" role="dialog" aria-labelledby="" aria-hiddeen="true">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>
	
	<script src="js/globals.js"></script>
</body>
</html>