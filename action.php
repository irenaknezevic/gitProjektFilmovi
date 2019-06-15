<?php

include 'connection.php';

header('Content-type: text/json');
header('Content-type: application/json; charset=utf-8');


$action_id="";
if(!empty($_POST['action_id']))
{
	$action_id = $_POST['action_id'];
}
if(!empty($_GET['action_id']))
{
	$action_id = $_GET['action_id'];
}

$film_id="";
if(!empty($_POST['film_id']))
{
	$film_id = $_POST['film_id'];
}
if(!empty($_GET['film_id']))
{
	$film_id = $_GET['film_id'];
}



$oJson = array();

switch($action_id)
{
	case 'novi_film':
		session_start();
		$korisnik_id = $_SESSION['id'];
		$sQuery = "SELECT * FROM filmovi WHERE korisnik_id=".$korisnik_id." AND naziv_filma='".$_POST['naziv']."'";

		$result = $oConnection->query($sQuery);
		// var_dump($result);
		$oRow = $result->fetch(PDO::FETCH_BOTH);
		// var_dump($oRow);
		if(empty($oRow))
		{
			$sQueryAdd = "INSERT INTO filmovi (korisnik_id, naziv_filma, godina, zanr, trajanje, glumci, redatelj, slika, sadrzaj, moja_ocjena) VALUES (:id, :naziv, :godina, :zanr, :trajanje, :glumci, :redatelj, :slika, :sadrzaj, :moja_ocjena) ";

			$oStatement = $oConnection->prepare($sQueryAdd);
			if(!empty($_SESSION['id']))
			{
				$oData = array(
					'id' => $_SESSION['id'],
					'naziv' => $_POST['naziv'],
					'godina' => $_POST['godina'],
					'zanr' => $_POST['zanr'],
					'trajanje' => $_POST['trajanje'],
					'glumci' => $_POST['glumci'],
					'redatelj' => $_POST['redatelj'],
					'slika' => $_POST['slika'],
					'sadrzaj' => $_POST['sadrzaj'],
					'moja_ocjena' => $_POST['moja_ocjena'],
				);
				$oStatement->execute($oData);
				// var_dump($oData);
				header("Location: filmovi.php");
			}
		}
		else
		{
			header("Location: filmovi.php");
			// echo '<script type="text/javascript">
			// 	alert("Film se već nalazi u bazi!");
			// </script>';
		}
	break;
	case 'spremiFilm':
		$json = array(json_decode($_POST['podaciFilma']));
		echo $json['Title'];
		break;
	case 'filmovi_korisnika':
		session_start();
		$korisnik_id = $_SESSION['id'];
		$sQuery = "SELECT * FROM filmovi WHERE korisnik_id=".$korisnik_id;

		if (!empty($_GET['moja_ocjena'])) { 
			$sQuery .= " AND moja_ocjena=".$_GET['moja_ocjena'];
		}
		if (!empty($_GET['zanr'])) {
			$sQuery .= " AND zanr LIKE '%".$_GET['zanr']."%'";
		}

		$oRecord = $oConnection->query($sQuery);			

		while($oRow = $oRecord->fetch(PDO::FETCH_ASSOC))
		{
			$oFilmovi = array();
			
			$oFilmovi['film_id'] = $oRow['film_id'];
			$oFilmovi['naziv_filma'] = $oRow['naziv_filma'];
			$oFilmovi['godina'] = $oRow['godina'];
			$oFilmovi['zanr'] = $oRow['zanr'];
			$oFilmovi['moja_ocjena'] = $oRow['moja_ocjena'];

			array_push($oJson, $oFilmovi);
		}
		$tablica = json_encode($oJson);
		echo $tablica;
	break;

	case 'odabrani_film':
		$sQuery = "SELECT * FROM filmovi WHERE film_id=".$film_id;

		$oRecord = $oConnection->query($sQuery);			

		while($oRow = $oRecord->fetch(PDO::FETCH_ASSOC))
		{
			array_push($oJson, $oRow);
		}
		$info = json_encode($oJson);
		echo $info;
	break;

	case 'obrisi_film':
		$sQueryDelete = "DELETE FROM filmovi WHERE film_id=".$film_id;
		$oStatement = $oConnection->query($sQueryDelete);
		header("Location: filmovi.php");
		// echo $sQueryDelete;
	break;
}

//echo json_encode($oJson);

?>