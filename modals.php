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
			<form class="form-horizontal" action="templates/film_temp.php" method="POST">

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
}
?>