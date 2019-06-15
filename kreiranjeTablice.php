<?php 
include 'connection.php';

$sQuery = 'CREATE TABLE IF NOT EXISTS `bazafilmovi`.`korisnici` (
  `korisnik_id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NULL,
  `korisnicko_ime` VARCHAR(45) NULL,
  `lozinka` VARCHAR(45) NULL,
  PRIMARY KEY (`korisnik_id`))
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bazafilmovi`.`filmovi` (
  `film_id` INT NOT NULL AUTO_INCREMENT,
  `korisnik_id` INT NULL,
  `naziv_filma` VARCHAR(100) NULL,
  `godina` VARCHAR(10) NULL,
  `zanr` VARCHAR(45) NULL,
  `trajanje` VARCHAR(10) NULL,
  `glumci` VARCHAR(1000) NULL,
  `redatelj` VARCHAR(255) NULL,
  `slika` VARCHAR(1000) NULL,
  `sadrzaj` VARCHAR(1000) NULL,
  `moja_ocjena` INT NULL,
  PRIMARY KEY (`film_id`),
  CONSTRAINT `fk_film_korisnik`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `bazafilmovi`.`korisnici` (`korisnik_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;
';

$oConnection->query($sQuery);

?>