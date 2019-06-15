<?php 
include 'connection.php';

header('Content-type: charset=utf-8');

$sQuery = 'SELECT * FROM korisnici WHERE korisnicko_ime="'.$_POST['korime'].'" AND lozinka="'.$_POST['lozinka'].'"';

$oStatement = $oConnection->query($sQuery);
$oData = $oStatement->fetch(PDO::FETCH_ASSOC);
// var_dump($oData);

if(!empty($oData['korisnicko_ime']))
{
	$oKorisnik = new Korisnik ($oData['korisnik_id'], $oData['ime'], $oData['korisnicko_ime'], $oData['lozinka']);
	session_start();
	$_SESSION['id'] = $oKorisnik->korisnik_id;
	$_SESSION['ime'] = $oKorisnik->ime;
	header("Location: filmovi.php");
	// var_dump($oKorisnik);
	// echo $_SESSION['id'];
	// echo $_SESSION['ime'];
}
else
{
	header("Location: pocetna.php");
}

?>