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
    <link rel="stylesheet" href="../css/style4.css">
</head>  
<body ng-controller="filmoviController" ng-init="init('<?php echo $_POST['naziv'] ?>')">
    <div class="navbar navbar-fixed-top">
        <button class="btn btn-danger btn-s" id="nazad">Odustani</button>
    </div>

    <div class="container">

        <div ng-repeat="oFilm in oFilmovi" class="col-xs-5 col-sm-5 col-md-3 col-lg-2">
            <h4 class="titleFilma">{{oFilm.Title}} ({{oFilm.Year}})</h4>
            <img src="{{oFilm.Poster}}">
            <form action="film_temp.php" method="POST">
                <input type="hidden" name="imdbId" value="{{oFilm.imdbID}}">
                <button id="btnPregledajFilm" type="submit" class="btn btn-primary">Otvori film</button>
            </form>
        </div>

    </div>

    <br>

    <script type="text/javascript" src="../js/app.js"></script>
</body>
</html>