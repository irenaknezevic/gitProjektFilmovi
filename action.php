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
	case 'novi_korisnik':
		$sQuery = "SELECT * FROM korisnici WHERE korisnicko_ime='".$_POST['korime']."' OR nadimak = '".$_POST['nadimak']."'";

		$result = $oConnection->query($sQuery);
		// var_dump($result);
		$oRow = $result->fetch(PDO::FETCH_ASSOC);
		// var_dump($oRow);
		if(empty($oRow))
		{

			$slika = "img/korisnik.png";

			if($_FILES['slika']['error'] == 0)
			{
				//Prebrojavanje korisnika
				$sQueryBrojKorisnika = "SELECT COUNT(*) FROM korisnici";

				$resultBrojKorisnika = $oConnection->query($sQueryBrojKorisnika);

				$brKorisnika = $resultBrojKorisnika->fetch(PDO::FETCH_ASSOC)['COUNT(*)']+1;
				//---------------------------

				$direktorij = "slikeKorisnika";

				$imeSlike = $_FILES['slika']['name'];

				list($ime, $ekstenzija) = explode(".", $imeSlike);

				$tmp_datoteka = $_FILES['slika']['tmp_name'];

				$slika = "$direktorij/$brKorisnika".".".$ekstenzija;

				move_uploaded_file($tmp_datoteka, $slika);

			}

			$sQueryAddUser = "INSERT INTO korisnici (ime, prezime, korisnicko_ime, lozinka, nadimak, slika) VALUES ('".$_POST['ime']."', '".$_POST['prezime']."', '".$_POST['korime']."', '".$_POST['lozinka']."', '".$_POST['nadimak']."', '".$slika."')";

			$oConnection->query($sQueryAddUser);

			$resultUser = $oConnection->query($sQuery);

			$user = $resultUser->fetch(PDO::FETCH_ASSOC);

			session_start();
			$_SESSION['id'] = $user['korisnik_id'];

			header("Location: autentifikacija.php");
		}
		else
		{
			session_start();
			$_SESSION['usernameTaken'] = 'true';
			header("Location: pocetna.php");
		}
	break;

	case 'dohvati_korisnike':
		session_start();
		$user_id = $_SESSION['id'];

		$korisnici = [];

		$sQuery = "SELECT * FROM korisnici WHERE korisnik_id !=".$user_id;
		$result = $oConnection->query($sQuery);

		while ($oRow = $result->fetch(PDO::FETCH_ASSOC)) 
		{
			$korisnik = array(
				'korisnicko_ime' => $oRow['korisnicko_ime'],
				'ime' => $oRow['ime'],
				'slika' => $oRow['slika']
			);

			array_push($korisnici, $korisnik);
		}

		$json = json_encode($korisnici);
		echo $json;

	break;

	case 'novi_film':
		session_start();
		$korisnik_id = $_SESSION['id'];

		$nazivFilma = $_POST['naziv'];
		if (strpos($_POST['naziv'], "'") !== false) {
			$nazivFilma = str_replace("'", "`", $_POST['naziv']);	    
		}
		$sQuery = "SELECT * FROM filmovi WHERE korisnik_id=".$korisnik_id." AND naziv_filma='".$nazivFilma."'";

		$result = $oConnection->query($sQuery);
		// var_dump($result);
		$oRow = $result->fetch(PDO::FETCH_ASSOC);
		// var_dump($oRow);
		if(empty($oRow))
		{
			$sQueryAdd = "INSERT INTO filmovi (korisnik_id, naziv_filma, godina, zanr, trajanje, glumci, redatelj, slika, sadrzaj, moja_ocjena, imdb_id) VALUES (:id, :naziv, :godina, :zanr, :trajanje, :glumci, :redatelj, :slika, :sadrzaj, :moja_ocjena, :imdb_id)";

			$oStatement = $oConnection->prepare($sQueryAdd);
			if(!empty($_SESSION['id']))
			{
				$oData = array(
					'id' => $_SESSION['id'],
					'naziv' => $nazivFilma,
					'godina' => $_POST['godina'],
					'zanr' => $_POST['zanr'],
					'trajanje' => $_POST['trajanje'],
					'glumci' => $_POST['glumci'],
					'redatelj' => $_POST['redatelj'],
					'slika' => $_POST['slika'],
					'sadrzaj' => $_POST['sadrzaj'],
					'moja_ocjena' => $_POST['moja_ocjena'],
					'imdb_id' => $_POST['imdbIdFilma']
				);
				$oStatement->execute($oData);
				/*var_dump($oData);
				echo $sQueryAdd;*/

				//ZAPISI U OCJENE 
				$sQueryDohvatiFilm = "SELECT film_id FROM filmovi WHERE korisnik_id=".$korisnik_id." AND imdb_id='".$_POST['imdbIdFilma']."'";
				$dbFilm = $oConnection->query($sQueryDohvatiFilm);
				$film = $dbFilm->fetch(PDO::FETCH_ASSOC);

					//DOHVATI DATUM
					date_default_timezone_set('Europe/Zagreb');
					$datum = "'".date('d.m.Y.')."'";
					//------------------------------

				$sQueryZapisiOcjenu = "INSERT INTO ocjene (film_id, ocjena, datum) VALUES (".$film['film_id'].", ".$_POST['moja_ocjena'].", ".$datum.")";

				$oConnection->query($sQueryZapisiOcjenu);
				//------------------------------------

						
				header("Location: filmovi.php");

			}
		}
		else
		{
			session_start();
			$_SESSION['movieWarning'] = 'warning';
			header("Location: filmovi.php");
		}
	break;
	/*case 'spremiFilm':
		$film = json_decode($_POST['podaciFilma']);

		session_start();
		$korisnik_id = $_SESSION['id'];
		//var_dump($json);
		$sQueryAdd = "INSERT INTO filmovi (korisnik_id, naziv_filma, godina, zanr, trajanje, glumci, redatelj, slika, sadrzaj, moja_ocjena) VALUES (:id, :naziv, :godina, :zanr, :trajanje, :glumci, :redatelj, :slika, :sadrzaj, :moja_ocjena, :imdb_id) ";

			$oStatement = $oConnection->prepare($sQueryAdd);
			if(!empty($_SESSION['id']))
			{
				$oData = array(
					'id' => $_SESSION['id'],
					'naziv' => $film->Title,
					'godina' => $film->Year,
					'zanr' => $film->Genre,
					'trajanje' => $film->Runtime,
					'glumci' => $film->Actors,
					'redatelj' => $film->redatelj,
					'slika' => $film->slika,
					'sadrzaj' => $film->sadrzaj,
					'moja_ocjena' => $film->moja_ocjena,
					'imdb_id' => $_POST['imdbIdFilma']
				);
				$oStatement->execute($oData);
				// var_dump($oData);
				header("Location: filmovi.php");
			}
		break;*/
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

	case 'dohvati_ocjene_filma':
		$sQuery = "SELECT * FROM ocjene WHERE film_id=".$film_id;

		$sRezultat = $oConnection->query($sQuery);

		while($oRow = $sRezultat->fetch(PDO::FETCH_ASSOC))
		{
			array_push($oJson, $oRow);
		}
		$ocjene = json_encode($oJson);
		echo $ocjene;
	break;

	case 'obrisi_film':
		$sQueryDelete = "DELETE FROM filmovi WHERE film_id=".$film_id;
		$oConnection->query($sQueryDelete);
		header("Location: filmovi.php");
		// echo $sQueryDelete;
	break;

	case 'preporuci_film':
		session_start();
		$korisnik_id = $_SESSION['id'];

		$dbKorisnici = [];
		
		$sQueryGetUser = "SELECT * FROM korisnici WHERE korisnicko_ime IN (".$_POST['korisnici'].")";

		$oRecord = $oConnection->query($sQueryGetUser);			

		while($oRow = $oRecord->fetch(PDO::FETCH_ASSOC))
		{
			$sQueryWrite = "INSERT INTO preporuceni_filmovi (posiljatelj_id, primatelj_id, imdb_id) VALUES (".$korisnik_id.", ".$oRow['korisnik_id'].", '".$_POST['film_id']."')";

			$oConnection->query($sQueryWrite);
			
			header("Location: templates/prikaz_filma_temp.php");
			session_start();
			$_SESSION['preporuka'] = "preporuka";
		}
		
		
		/*var_dump($dbKorisnici);*/
		/*header("Location: filmovi.php");*/
	break;

	case 'obrisi_preporuku':

		session_start();
		$korisnik_id = $_SESSION['id'];

		$sQueryDelete = "DELETE FROM preporuceni_filmovi WHERE primatelj_id=".$korisnik_id." AND imdb_id='".$film_id."'";
		$oConnection->query($sQueryDelete);
		header("Location: preporuceni.php");

	break;

	case 'dohvati_preporucene_filmove':
		session_start();
		$korisnik_id = $_SESSION['id'];

		$sQueryGetMovies = "SELECT * FROM preporuceni_filmovi WHERE primatelj_id =".$korisnik_id;

		$oRecord = $oConnection->query($sQueryGetMovies);

		while($oRow = $oRecord->fetch(PDO::FETCH_ASSOC))
		{
			$sQueryCheckMovie = "SELECT * FROM filmovi WHERE korisnik_id=".$korisnik_id." AND imdb_id='".$oRow['imdb_id']."'";
			$checkResult = $oConnection->query($sQueryCheckMovie);

			if($check = $checkResult->fetch(PDO::FETCH_ASSOC))
			{
				//var_dump($check);
				$sQueryDelete = "DELETE FROM preporuceni_filmovi WHERE primatelj_id=".$korisnik_id." AND imdb_id='".$oRow['imdb_id']."'";

				$oConnection->query($sQueryDelete);
			}
			else
			{
				$sQueryGetUser = "SELECT * FROM korisnici WHERE korisnik_id=".$oRow['posiljatelj_id'];

				$oKorisnikDb = $oConnection->query($sQueryGetUser);

				$korisnik = $oKorisnikDb->fetch(PDO::FETCH_ASSOC);

				$oPreporuka = array();

				$oPreporuka['posiljatelj'] = $korisnik['ime']." ".$korisnik['prezime']." (".$korisnik['nadimak'].")";
				$oPreporuka['imdb_id'] = $oRow['imdb_id'];

				array_push($oJson, $oPreporuka);
			}
		}

		$json = json_encode($oJson);
		echo $json;

	break;

	case 'promjena_ocjene':

		session_start();
		$korisnik_id = $_SESSION['id'];

		$imdb_id = $_POST['imdb_id'];

		//DOHVATI FILM
		$sQueryFilm = "SELECT * FROM filmovi WHERE korisnik_id=".$korisnik_id." AND imdb_id='".$imdb_id."'";

		$dbFilm = $oConnection->query($sQueryFilm);
		$film = $dbFilm->fetch(PDO::FETCH_ASSOC);

		$film_id = $film['film_id'];
		//-------------------------------------

		//DOHVATI DATUM
		date_default_timezone_set('Europe/Zagreb');
		$datum = "'".date('d.m.Y.')."'";
		//------------------------------


		if(!empty($_POST['novaOcjena']))
		{
			$sQueryUpdateOcjene = "UPDATE filmovi SET moja_ocjena=".$_POST['novaOcjena']." WHERE film_id=".$film_id;

			$oConnection->query($sQueryUpdateOcjene);

			$sQueryZapisiOcjenu = "INSERT INTO ocjene (film_id, ocjena, datum) VALUES (".$film_id.", ".$_POST['novaOcjena'].", ".$datum.")";

			$oConnection->query($sQueryZapisiOcjenu);

			header("Location: templates/prikaz_filma_temp.php");
		}


	break;

	case 'azuriranje_profila':

		session_start();
		$korisnik_id = $_SESSION['id'];

		$setQueryUpdate = AzuriranjeProfila($oConnection, $korisnik_id);

		$sQueryUpdateProfila = "UPDATE korisnici SET ".$setQueryUpdate." WHERE korisnik_id=".$_SESSION['id'];
		//echo $sQueryUpdateProfila;
		$oStatement = $oConnection->query($sQueryUpdateProfila);

		header('Location: profil.php');

	break;
}

function AzuriranjeProfila($con, $id)
{
	$string = "";

	if(!empty($_POST['inputAzuriranjeImena']) && $_POST['inputAzuriranjeImena'] != '')
	{
		$string .= "ime='".$_POST['inputAzuriranjeImena']."'";
	}

	if(!empty($_POST['inputAzuriranjePrezimena']) && $_POST['inputAzuriranjePrezimena'] != '')
	{
		if($string != "")
		{
			$string .= ", prezime='".$_POST['inputAzuriranjePrezimena']."'";
		}
		else
		{
			$string .= "prezime='".$_POST['inputAzuriranjePrezimena']."'";
		}
	}

	if(!empty($_POST['inputAzuriranjeKor']) && $_POST['inputAzuriranjeKor'] != '')
	{
		if($string != "")
		{
			$string .= ", korisnicko_ime='".$_POST['inputAzuriranjeKor']."'";
		}
		else
		{
			$string .= "korisnicko_ime='".$_POST['inputAzuriranjeKor']."'";
		}
	}

	if(!empty($_POST['inputAzuriranjeLozinke']) && $_POST['inputAzuriranjeLozinke'] != '')
	{
		if($string != "")
		{
			$string .= ", lozinka='".$_POST['inputAzuriranjeLozinke']."'";
		}
		else
		{
			$string .= "lozinka='".$_POST['inputAzuriranjeLozinke']."'";
		}
	}

	if(!empty($_POST['inputAzuriranjeNadimka']) && $_POST['inputAzuriranjeNadimka'] != '')
	{
		if($string != "")
		{
			$string .= ", nadimak='".$_POST['inputAzuriranjeNadimka']."'";
		}
		else
		{
			$string .= "nadimak='".$_POST['inputAzuriranjeNadimka']."'";
		}
	}

	if($_FILES['inputAzuriranjeSlike']['error'] == 0)
	{

		if($_SESSION['slikaKorisnika'] != 'img/korisnik.png')
		{
			unlink($_SESSION['slikaKorisnika']);
		}
		
		$direktorij = "slikeKorisnika";

		$imeSlike = $_FILES['inputAzuriranjeSlike']['name'];

		list($ime, $ekstenzija) = explode(".", $imeSlike);

		$tmp_datoteka = $_FILES['inputAzuriranjeSlike']['tmp_name'];

		$slika = "$direktorij/$id".".".$ekstenzija;

		move_uploaded_file($tmp_datoteka, $slika);

		if($string != "")
		{
			$string .= ", slika='".$slika."'";
		}
		else
		{
			$string .= "slika='".$slika."'";
		}

	}

	return $string;
}

//echo json_encode($oJson);

?>