<?php 
include 'connection.php';

$sQuery = 'CREATE TABLE IF NOT EXISTS `bazafilmovi`.`korisnici` (
  `korisnik_id` INT NOT NULL AUTO_INCREMENT,
  `ime` VARCHAR(45) NOT NULL,
  `prezime` VARCHAR(45) NOT NULL,
  `korisnicko_ime` VARCHAR(45) NOT NULL,
  `lozinka` VARCHAR(45) NOT NULL,
  `nadimak` VARCHAR(45) NOT NULL,
  `slika` VARCHAR (255) NOT NULL,
  PRIMARY KEY (`korisnik_id`))
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `bazafilmovi`.`filmovi` (
  `film_id` INT NOT NULL AUTO_INCREMENT,
  `korisnik_id` INT NULL,
  `naziv_filma` VARCHAR(100) NULL,
  `godina` VARCHAR(10) NULL,
  `zanr` VARCHAR(100) NULL,
  `trajanje` VARCHAR(10) NULL,
  `glumci` VARCHAR(1000) NULL,
  `redatelj` VARCHAR(255) NULL,
  `slika` VARCHAR(1000) NULL,
  `sadrzaj` VARCHAR(1000) NULL,
  `moja_ocjena` INT NULL,
  `imdb_id` VARCHAR(45) NULL,
  PRIMARY KEY (`film_id`),
  CONSTRAINT `fk_film_korisnik`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `bazafilmovi`.`korisnici` (`korisnik_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bazafilmovi`.`preporuceni_filmovi` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posiljatelj_id` INT NULL,
  `primatelj_id` INT NULL,
  `imdb_id` VARCHAR(20) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_film_posiljatelj`
    FOREIGN KEY (`posiljatelj_id`)
    REFERENCES `bazafilmovi`.`korisnici` (`korisnik_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_film_primatelj`
    FOREIGN KEY (`primatelj_id`)
    REFERENCES `bazafilmovi`.`korisnici` (`korisnik_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bazafilmovi`.`ocjene` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `film_id` INT NULL,
  `ocjena` INT NULL,
  `vrijeme_datum` VARCHAR(50) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ocjena_film`
    FOREIGN KEY (`film_id`)
    REFERENCES `bazafilmovi`.`filmovi` (`film_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;
';

$oConnection->query($sQuery);

?>