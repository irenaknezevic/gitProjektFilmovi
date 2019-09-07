<?php 

session_start();
if(empty($_SESSION['id']))
{
    header("Location: ../pocetna.php");
}
else
{

    if(!empty($_SESSION['preporuka']))
    {
    ?>
        <script type="text/javascript">
            alert("Preporučili ste film!");
        </script>
    <?php
    unset($_SESSION['preporuka']);
    }

    if(!empty($_SESSION['ocjenaPrazna']))
    {
    ?>
        <script type="text/javascript">
            alert("Niste odabrali ocjenu!");
        </script>
    <?php
        unset($_SESSION['ocjenaPrazna']);
    }

?>

<!DOCTYPE html>
<html>
<head lang="en">
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
<body ng-app="filmovi-app">
    <div class="navbar navbar-fixed-top">
        <button class="btn btn-danger btn-s" id="nazad">Nazad</button>
        <button data-toggle="modal" data-target="#modals" class="btn btn-primary btn-s" id="preporuci">Preporuči film</button>
    </div>

    <div class="container" ng-controller="odabraniFilmController">
        <div ng-repeat="film in oFilm">
           <div id="slika">
                <img src="{{film.slika}}">
            </div>
            <div id="info">
                <h1>{{film.naziv_filma}}</h1>
                <label>{{film.godina}}. | {{film.zanr}} | {{film.trajanje}}</label>
                <br>
                <br>
                <br>
                <p><span>Glumci:</span> {{film.glumci}}</p>
                <br>
                <p><span>Redatelj:</span> {{film.redatelj}}</p>
                <br>
                <p><span>Ukratko:</span> {{film.sadrzaj}}</p>
                <br>
                <p><span>Moja ocjena:</span> {{film.moja_ocjena}}</p>
                <button data-toggle="modal" data-target="#modalOcjena" class="btn btn-primary btn-s" id="ocjena">Promijeni ocjenu</button>
                <br>
            </div> 

            <br>
            <br>
            
            <div id="tablica_ocjena" ng-controller="ocjeneFilmaController">
                <tablica-ocjena>
                    <!-- DIREKTIVA -->
                </tablica-ocjena>
            </div>

            <!-- PREPORUCI FILM -->
            <div class="modal" id="modals" tabindex="-1" role="dialog" aria-labelledby="" aria-hiddeen="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#3F3F3F">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:white">&times;</button>
                            <h4 class="modal-title" style="color:white">Preporuči film</h4>
                        </div>
                        <br>
                        <div class="modal-body" ng-controller="korisniciController">
                            <form class="form-horizontal" action="../action.php" method="POST" >

                                <input type="hidden" name="action_id" value="preporuci_film">

                                <input type="hidden" name="film_id" value="{{film.imdb_id}}">

                                <input type="hidden" name="korisnici">
                                
                                <div class="col-lg-4 col-xs-4"></div>
                                <h4 class="col-lg-6 col-xs-6">Odaberi korisnika/e:</h4>

                                <table id="tablicaKorisnika" class="table table-hover col-lg-12 col-xs-12">
                                    <thead>
                                        <th>Slika korisnika</th>
                                        <th>Ime</th>
                                        <th>Korisničko ime</th>
                                        <th></th>
                                    </thead>
                                    <div id="bodyKorisnici">
                                        <tbody>
                                            <tr ng-repeat="oKorisnik in oKorisnici">
                                                <td><img id="slikaKorisnika" src="../{{oKorisnik.slika}}"></td>
                                                <td>{{oKorisnik.ime}}</td>
                                                <td>{{oKorisnik.korisnicko_ime}}</td>
                                                <td><input onclick="CheckboxKorisnici()" type="checkbox" name="korisnik" value="{{oKorisnik.korisnicko_ime}}" required autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </div>
                                    
                                </table>
                                
                                <div class="modal-footer">
                                        <button id="oznaciKorisnike" onclick="OznaciSveKorisnike()" class="btn btn-success" type="button">Označi sve</button>
                                        <button id="odznaciKorisnike" onclick="OdznaciSveKorisnike()" class="btn btn-danger" type="button">Odznači sve</button>

                                        <button type="submit" class="btn btn-primary">Preporuči</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROMIJENI OCJENU FILMA -->
            <div class="modal" id="modalOcjena" tabindex="-1" role="dialog" aria-labelledby="" aria-hiddeen="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#3F3F3F">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color:white">&times;</button>
                            <h4 class="modal-title" style="color:white">Promjena ocjene filma</h4>
                        </div>
                        <br>
                        <div class="modal-body">
                            <form class="form-horizontal" action="../action.php" method="POST" >

                                <input type="hidden" name="action_id" value="promjena_ocjene">

                                <input type="hidden" name="imdb_id" value="{{film.imdb_id}}">

                                <!-- <select name="novaOcjena" required class="form-control">
                                    <option value="" selected disabled>Odaberi ocjenu:</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select> -->
                                <label>Odaberite ocjenu:</label>
                                <br>
                                <input type="hidden" name="novaOcjena" value="" required>

                                <button class="btn ocjenaButtons" type="button" onclick="ocjenaButton(1)">1</button>
                                <button class="btn ocjenaButtons" type="button" onclick="ocjenaButton(2)">2</button>
                                <button class="btn ocjenaButtons" type="button" onclick="ocjenaButton(3)">3</button>
                                <button class="btn ocjenaButtons" type="button" onclick="ocjenaButton(4)">4</button>
                                <button class="btn ocjenaButtons" type="button" onclick="ocjenaButton(5)">5</button>
                                <br>
                                <br>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-danger">Odustani</button>
                                    <button type="submit" class="btn btn-primary">Spremi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <br>

    <script type="text/javascript" src="../js/app.js"></script>
    <script type="text/javascript" src="../js/globals.js"></script>
</body>
</html>

<?php 

}
 ?>