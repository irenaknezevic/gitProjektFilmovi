<?php 
include 'connection.php';

header('Content-type: charset=utf-8');

session_start();
$sQuery = '';
if(!empty($_POST['korime']) && !empty($_POST['lozinka']))
{
	$sQuery = 'SELECT * FROM korisnici WHERE korisnicko_ime="'.$_POST['korime'].'" AND lozinka="'.$_POST['lozinka'].'"';
}
elseif (!empty($_SESSION['user_id'])) {
	$sQuery = "SELECT * FROM korisnici WHERE korisnik_id=".$_SESSION['user_id'];
	session_destroy();
}
else
{
	header("Location: pocetna.php");
}


$oStatement = $oConnection->query($sQuery);
$oData = $oStatement->fetch(PDO::FETCH_ASSOC);
// var_dump($oData);

if(!empty($oData['korisnicko_ime']))
{
	$oKorisnik = new Korisnik ($oData['korisnik_id'], $oData['ime'], $oData['korisnicko_ime'], $oData['lozinka']);
	session_start();
	$_SESSION['id'] = $oKorisnik->korisnik_id;
	$_SESSION['ime'] = $oKorisnik->ime;
	//header("Location: filmovi.php");
	var_dump($oKorisnik);
	echo $_SESSION['id'];
	echo $_SESSION['ime'];
}
else
{
	session_start();
	$_SESSION['authFail'] = 'true';
	header("Location: pocetna.php");
}

?>