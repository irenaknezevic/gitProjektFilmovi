<?php
include 'connection.php';

$sModalID = "";
if(!empty($_GET['modal_id']))
{
	$sModalID = $_GET['modal_id'];
}
if(!empty($_POST['modal']))
{
	$sModalID=$_POST['modal'];
}


$sFilmID = "";
if(!empty($_GET['film_id']))
{
	$sFilmID = $_GET['film_id'];
}



switch ($sModalID) 
{
	case 'dodaj_film':
		echo 
			'<div class="modal-header" style="background-color:#3F3F3F">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="color:white">Novi film</h4>
			</div>
			<br>
			<form class="form-horizontal" action="templates/pretrazeni_filmovi_temp.php" method="POST">

				<div class="form-group">
							<label class="control-label col-lg-3 col-xs-3">Naziv filma:</label>
							<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="naziv" required></div>
				</div>
				<div class="modal-footer">
							<button type="submit" class="btn btn-danger btn-s">Traži</button>
				</div>
			</form>';
	break;
	
	case 'obrisi_film':
		echo
			'<div class="modal-header" style="background-color:#3F3F3F">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="color:white">Brisanje</h4>
			</div>
			<br>
			<form class="form-horizontal" action="action.php" method="POST">

				<input type="hidden" name="action_id" value="obrisi_film">
				<input type="hidden" name="film_id" value="'.$sFilmID.'">

				<div class="form-group" style="text-align:center;">
							<h4>
								Jeste li sigurni da želite obrisati film?
							</h4>
				</div>
				<div class="modal-footer">
							<button type="submit" class="btn btn-danger btn-s">Obriši</button>
				</div>
			</form>';
	break;

	case 'novi_korisnik':
		echo 
		'<div class="modal-header" style="background-color:#3F3F3F">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:white">&times;</button>
					<h4 class="modal-title" style="color:white">Registracija</h4>
			</div>
			<br>
			<form class="form-horizontal" action="action.php" method="POST" enctype="multipart/form-data">

				<input type="hidden" name="action_id" value="novi_korisnik">
				

				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Ime:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="ime" required></div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Prezime:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="prezime" required></div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Korisničko ime:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="korime" required></div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Lozinka:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="password" name="lozinka" required></div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Nadimak:</label>
						<div class="col-lg-8 col-xs-8"><input class="form-control" type="text" name="nadimak" required></div>
				</div>
				<div class="form-group">
						<label class="control-label col-lg-3 col-xs-3">Slika profila:</label>
						<div class="col-lg-8 col-xs-8"><input type="file" accept="image/*" name="slika"></div>
				</div>
				<div class="modal-footer">
						<button type="submit" class="btn btn-danger btn-s">Registriraj se</button>
				</div>
			</form>';
	break;

	case 'preporuci_film':
?>
		<div class="modal-header" style="background-color:#3F3F3F">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:white">&times;</button>
			<h4 class="modal-title" style="color:white">Preporuči film</h4>
		</div>
		<br>
		<div class="modal-body" ng-controller="korisniciController">
			<form class="form-horizontal" action="action.php" method="POST" >

				<input type="hidden" name="action_id" value="preporuci_film">
				
				<div class="col-lg-4 col-xs-4"></div>
				<h4 class="col-lg-6 col-xs-6">Odaberi korisnika/e:</h4>

				<div>
					<table>
						<thead>
							<th>Ime</th>
							<th>Korisničko ime</th>
						</thead>
						<tbody>
							<tr ng-repeat="oKorisnik in oKorisnici">
								<td>{{$scope.oKorisnik.ime}}</td>
								<td>{{oKorisnik.korisnicko_ime}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Preporuči</button>
				</div>
			</form>
		</div>
<?php
	break;
}
?>