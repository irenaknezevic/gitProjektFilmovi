<?php 

if(empty($_POST['imdbId']))
{
    
?>
    <script type="text/javascript">
        alert("Nije moguće dohvatiti film");
        window.location.href = "pretrazeni_filmovi_temp.php";
    </script>
<?php
}
else
{
 ?>
<!DOCTYPE html>
<html ng-app="filmovi-app">
<head>
    <meta charset="UTF-8">
    <title>Moji filmovi</title>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="../js/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style3.css">
</head>  
<body ng-controller="filmController" ng-init="init('<?php echo $_POST['imdbId'] ?>')">
    <div class="navbar navbar-fixed-top">
        <button class="btn btn-danger btn-s" id="nazad">Odustani</button>
        <div class="container-fluid navbar-right">
            <form action="../action.php" method="POST" id="spremiFilm">
                <input type="hidden" name="action_id" value="novi_film">
                <input type="hidden" name="slika" value="{{oFilm.Poster}}">
                <input type="hidden" name="naziv" value="{{oFilm.Title}}">
                <input type="hidden" name="godina" value="{{oFilm.Year}}">
                <input type="hidden" name="zanr" value="{{oFilm.Genre}}">
                <input type="hidden" name="trajanje" value="{{oFilm.Runtime}}">
                <input type="hidden" name="glumci" value="{{oFilm.Actors}}">
                <input type="hidden" name="redatelj" value="{{oFilm.Director}}">
                <input type="hidden" name="sadrzaj" value="{{oFilm.Plot}}">
                <input type="hidden" name="moja_ocjena">
                <input type="hidden" name="imdbIdFilma" value="<?php echo $_POST['imdbId'] ?>">
                <button class="btn btn-primary btn-s" type="submit" onclick="spremiSve(event)" id="btn_dodaj"><i class="fas fa-plus"></i> Spremi film</button>
            </form>
            
        </div>
    </div>

    <div class="container">

    	<div id="slika">
            <img src="{{oFilm.Poster}}">
        </div>
        <div id="info">
            <h1> {{oFilm.Title}} </h1>
            <label>{{oFilm.Year}}. | {{oFilm.Genre}} | {{oFilm.Runtime}}</label>
            <br>
            <br>
            <br>
            <p><span>Glumci:</span> {{oFilm.Actors}}</p>
            <br>
            <p><span>Redatelj:</span> {{oFilm.Director}}</p>
            <br>
            <p><span>Ukratko:</span> {{oFilm.Plot}}</p>
            <br>
            <select class="form-control col-lg-3 col-xs-3" id="odabir_ocjene" required>
                <option value="" disabled selected>Odaberite ocjenu:</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    </div>

    <br>

    <script type="text/javascript" src="../js/app.js"></script>
</body>
</html>

<?php
}
?>