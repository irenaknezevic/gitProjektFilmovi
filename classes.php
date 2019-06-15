<?php
class Configuration
{
	public $host = "localhost";
	public $dbName = "bazafilmovi";
	public $username = "root";
	public $password = "";

	// public function __construct($host, $dbName, $username, $password)
	// {
	// 	$this->host = $host;
	// 	$this->dbName = $dbName;
	// 	$this->username = $username;
	// 	$this->password = $password;
	// }
}

class Korisnik
{
	public $korisnik_id = "N/A";
	public $ime = "N/A";
	public $korisnicko_ime = "N/A";
	public $lozinka = "N/A";

	public function __construct($korisnik_id=NULL, $ime=NULL, $korisnicko_ime=NULL, $lozinka=NULL)
	{
		if($korisnik_id) $this->korisnik_id = $korisnik_id;
		if($ime) $this->ime = $ime;
		if($korisnicko_ime) $this->korisnicko_ime = $korisnicko_ime;
		if($lozinka) $this->lozinka = $lozinka;
	}
}

class Film
{
	public $film_id = "N/A";
	public $korisnik_id = "N/A";
	public $naziv_filma = "N/A";
	public $godina = "N/A";
	public $zanr = "N/A";
	public $trajanje = "N/A";
	public $glumci = "N/A";
	public $redatelj = "N/A";
	public $slika = "N/A";
	public $sadrzaj = "N/A";
	public $moja_ocjena = "N/A";

	public function __construct($film_id=NULL, $korisnik_id=NULL, $naziv_filma=NULL, $godina=NULL, $zanr=NULL, $trajanje=NULL, $glumci=NULL, $redatelj=NULL, $slika=NULL, $sadrzaj=NULL, $moja_ocjena=NULL)
	{
		if($film_id) $this->film_id = $film_id;
		if($korisnik_id) $this->korisnik_id = $korisnik_id;
		if($naziv_filma) $this->naziv_filma = $naziv_filma;
		if($godina) $this->godina = $godina;
		if($zanr) $this->zanr = $zanr;
		if($trajanje) $this->trajanje = $trajanje;
		if($glumci) $this->glumci = $glumci;
		if($redatelj) $this->redatelj = $redatelj;
		if($slika) $this->slika = $slika;
		if($sadrzaj) $this->sadrzaj = $sadrzaj;
		if($moja_ocjena) $this->moja_ocjena = $moja_ocjena;
	}
}
?>