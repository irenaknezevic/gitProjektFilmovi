<?php 
session_start();
if(!empty($_SESSION['ime']))
{
    if(!empty($_SESSION['movieWarning']))
    {
    ?>
        <script type="text/javascript">
            alert("Film je već dodan u 'Moji filmovi'!");
        </script>
    <?php
    unset($_SESSION['movieWarning']);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Moj profil</title>
    <script src="js/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="css/profil.css">
</head>
<body ng-app="filmovi-app">
    <div class="navbar navbar-fixed-top">
        <a href="filmovi.php"><button class="btn btn-danger btn-s" id="nazad">Nazad</button></a>
        <div class="container-fluid navbar-right">
            <button class="btn btn-danger btn-s" id="odjava" onclick="funkcijaOdjava()">Odjava</button>
        </div>
    </div>
    <div class="container">
        <div id="slikaProfila">
            <img src="img/film.jpg">
        </div>
        <button class="btn btn-basic btn-s">Učitaj fotografiju</button>
        <div id="detalji">
            <label for="inputAzuriranjeImena">Ime</label>
            <input type="text" class="form-control" id="inputAzuriranjeImena">
            <br>

            <label for="inputAzuriranjePrezimena">Prezime</label>
            <input type="text" class="form-control" id="inputAzuriranjePrezimena">
            <br>

            <label for="inputAzuriranjeKor">Korisnicko ime</label>
            <input type="text" class="form-control" id="inputAzuriranjeKor">
            <br>

            <label for="inputAzuriranjeLozinke">Lozinka</label>
            <input type="password" class="form-control" id="inputAzuriranjeLozinke">
            <br>

            <label for="inputAzuriranjeNadimka">Nadimak</label>
            <input type="text" class="form-control" id="inputAzuriranjeNadimka">
            <br>
        </div>

        <br>
        <br>
        <br>

        <button class="btn btn-primary btn-s" id="btn-azuriranje">Spremi promjene</button>   
    </div>

    <script type="text/javascript" src="js/globals.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
<!--    <script type="text/javascript" src="js/filmovi.js"></script>
 -->    
</body>
</html>

<?php 
}
else
{
    header("Location: pocetna.php");
}
?>