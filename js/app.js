var oFilmoviModul = angular.module('filmovi-app', []);

//ZA PRIKAZ DETALJA O FILMU KADA GA API PRONADE (nalazi se u film_temp.php)
oFilmoviModul.controller('filmoviController', function($scope, $http) {
	$scope.oFilmovi = [];
	
	$scope.init = function(naziv)
	{
		// $scope.naziv = naziv;
		$http({
			method: "GET",
			url: "http://www.omdbapi.com/?s="+naziv+"&apikey=e55c1343",
			}).then(function(response) {
				console.log(response.data);
				if(response.data['Response'] == "True")
				{
					$scope.oFilmovi = response.data['Search'];
				}
				else
				{
					alert("Film ne postoji!");
					window.location.href = "../filmovi.php";
				}
			},function(response) {
				console.log('Došlo je do pogreške!');
		});
	}

	$scope.pregledajFilm = function(imdbID)
	{
		$http({
			method: "GET",
			url: "http://www.omdbapi.com/?i="+imdbID+"&apikey=e55c1343",
			}).then(function(response) {
				console.log(response.data);
				if(response.data['Response'] == "True")
				{
					// $scope.oFilm = response.data;
					var jsondata = JSON.stringify(response.data);
					console.log(jsondata);
					// $http({
					// 	method: "POST",
					// 	url: "../action.php?action_id=spremiFilm",
					// 	data: {"podaciFilma": jsondata}
					// }).then(function(response){
					// 	console.log(response)
					// }, function(response){
					// 	console.log("ERROR: "+response);
					// });
					$.ajax({
					  type: "POST",
					  url: "../action.php?action_id=spremiFilm",
					  data: {podaciFilma: jsondata,
					  		imdbIdFilma: imdbID},
					  success: function(response){
					  	console.log(response);
					  }
					});
				}
				else
				{
					alert("Pogreška!");
					window.location.href = "../filmovi.php";
				}
			},function(response) {
				console.log('Došlo je do pogreške!');
		});
	}

	
});

oFilmoviModul.controller('filmController', function($scope, $http) {
	$scope.oFilm = [];
	
	$scope.init = function(imdbID)
	{
		// $scope.naziv = naziv;
		$http({
			method: "GET",
			url: "http://www.omdbapi.com/?i="+imdbID+"&apikey=e55c1343",
			}).then(function(response) {
				console.log(response.data);
				$scope.oFilm = response.data;
			},function(response) {
				console.log('Došlo je do pogreške!');
		});
	}

	/*$scope.spremiFilm = function(imdbID)
	{
		$http({
			method: "GET",
			url: "http://www.omdbapi.com/?i="+imdbID+"&apikey=e55c1343",
			}).then(function(response) {
				console.log(response.data);
				if(response.data['Response'] == "True")
				{
					// $scope.oFilm = response.data;
					var jsondata = JSON.stringify(response.data);
					console.log(jsondata);
					// $http({
					// 	method: "POST",
					// 	url: "../action.php?action_id=spremiFilm",
					// 	data: {"podaciFilma": jsondata}
					// }).then(function(response){
					// 	console.log(response)
					// }, function(response){
					// 	console.log("ERROR: "+response);
					// });
					$.ajax({
					  type: "POST",
					  url: "../action.php?action_id=spremiFilm",
					  data: {podaciFilma: jsondata,
					  		imdbIdFilma: imdbID},
					  success: function(response){
					  	console.log(response);
					  }
					});
				}
				else
				{
					alert("Film ne postoji!");
					window.location.href = "../filmovi.php";
				}
			},function(response) {
				console.log('Došlo je do pogreške!');
		});
	}*/
});

//PRIKAZ FILMOVA KORISNIKA KOJI JE PRIJAVLJEN (nalazi se u filmovi.php)
oFilmoviModul.controller('filmoviTabliceController', function($scope, $http) {
	$scope.oFilmovi = [];

	$http({
		method: "GET",
		url: "action.php?action_id=filmovi_korisnika"
	}).then(function(response) {
		// console.log(response.data);
		$scope.oFilmovi = response.data;
	},function(response) {
		// console.log(response);
		console.log('Došlo je do pogreške!');
	});

	$scope.dohvatiID = function(film) {
		console.log(film);
		localStorage.setItem("film_id", film);
	}

	$scope.mojaFunkcijaPretrage = function() {
		var selectZanr = document.getElementById("mojSelekt").value.toLowerCase();
		var filterZanr = "";
		if(selectZanr.length > 0)
		{
			filterZanr = "&zanr="+selectZanr;
		}
		
		var selectOcjena = document.getElementById("mojaOcjena").value;
		var filterOcjena = "";
		if(selectOcjena.length > 0)
		{
			filterOcjena = "&moja_ocjena="+selectOcjena;
		}
		
		var urlPretrage = "action.php?action_id=filmovi_korisnika" + filterZanr + filterOcjena;
		console.log($scope.oFilmovi);
		console.log(urlPretrage);
		$http({
			method: "GET",
			url: urlPretrage
		}).then(function(response) {
			console.log(response.data);

			$scope.oFilmovi = response.data;
		},function(response) {
			console.log(response.data);
			console.log('Došlo je do pogreške!');
		});
	}
});

//unutar direktive se prikazuje tablica s filmovima
oFilmoviModul.directive("naslovnicaFilm", function() {
	return {
		restrict: "E",
		templateUrl: "templates/tablice.html"
	};
});

oFilmoviModul.directive("naslovnicaPreporuceni", function() {
	return {
		restrict: "E",
		templateUrl: "templates/tablicaPreporuceni.html"
	};
});


//ZA PRIKAZ DETALJA O FILMU KOJI JE ODABRAN (prikaz_filma_temp.html)
oFilmoviModul.controller('odabraniFilmController', function($scope, $http) {
	$scope.oFilm = [];

	$http({
		method: "GET",
		url: "../action.php?action_id=odabrani_film&film_id="+localStorage.getItem("film_id")
	}).then(function(response) {
		console.log(response.data);
		$scope.oFilm = response.data;
	},function(response) {
		console.log('Došlo je do pogreške!');
	});
});

oFilmoviModul.controller('ocjeneFilmaController', function($scope, $http) {
	$scope.oOcjeneFilma = [];

	$http({
		method: "GET",
		url: "../action.php?action_id=dohvati_ocjene_filma&film_id="+localStorage.getItem("film_id")
	}).then(function (response) {
		console.log(response.data);
		$scope.oOcjeneFilma = response.data;
	},function(response) {
		console.log('Pogreška! '+response);
	});
});

//direktiva za zablicu ocjena
oFilmoviModul.directive("tablicaOcjena", function() {
	return {
		restrict: "E",
		templateUrl: "../templates/tablica_ocjene.html"
	};
});

//CONTROLLER ZA KORISNIKE 
oFilmoviModul.controller('korisniciController', function($scope, $http){
	$scope.oKorisnici = [];

	$http({
		method: 'GET',
		url: "../action.php?action_id=dohvati_korisnike"
	}).then(function(response){
		console.log("muy bien");
		console.log(response.data);
		$scope.oKorisnici = response.data;
		console.log($scope.oKorisnici);
	}, function(response){
		console.log('Došlo je do pogreške!');
	});
});

//CONTROLLER ZA PREPORUCENE FILMOVE
oFilmoviModul.controller('preporuceniFilmoviController', function($scope, $http){
	$scope.oPreporuke = [];
	$scope.oFilmovi = [];

	$http({
		method: "GET",
		url: "action.php?action_id=dohvati_preporucene_filmove"
	}).then(function(response){
		$scope.oPreporuke = response.data;
		//console.log($scope.oPreporuke);

		$scope.oPreporuke.forEach(function(pFilm){

			$http({
			method: "GET",
			url: "http://www.omdbapi.com/?i="+pFilm['imdb_id']+"&apikey=e55c1343",
			}).then(function(response) {
				
				var film = response.data;
				var oFilm = {
					naziv: film.Title,
					godina: film.Year,
					zanr: film.Genre,
					imdb_id: pFilm['imdb_id'],
					preporucitelj: pFilm['posiljatelj']
				};

				$scope.oFilmovi.push(oFilm);

			},function(response) {
				console.log('Došlo je do pogreške!');
			});

		console.log($scope.oFilmovi);

		});
		

	}, function(response){
		console.log(response);
		console.log('Pogreška pri dohvaćanju preporučenih filmova');
	});

	$scope.otvoriFilm = function(filmId) {
		$http({
    		method: 'POST',
		    url: 'templates/film_temp.php',
		    data: "imdbId=" + filmId,
		    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).then(function(response){
			window.location.href = "templates/film_temp.php";
		}, function(response){
			console.log(response);
		});
	}

	$scope.dohvatiID = function(film) {
		console.log(film);
		localStorage.setItem("film_id", film);
	}
});


function funkcijaOdjava()
{
	window.location.href = "odjava.php";
}


var btnNazad = document.querySelector("#nazad");
if(btnNazad)
{
	btnNazad.addEventListener("click", function ()
	{
		funkcijaNazad();
	});
}
function funkcijaNazad()
{
	document.location = "../filmovi.php";
}


function spremiSve(event)
{
	var e = document.querySelector("#odabir_ocjene");
	var mojaOcjena = e.options[e.selectedIndex].value;
	if(mojaOcjena == '')
	{
		event.preventDefault();
		alert('Upišite ocjenu filma!');
	}

	var inputOcjena = document.querySelector("input[name='moja_ocjena']");
	inputOcjena.setAttribute("value", mojaOcjena);
}

function CheckboxKorisnici()
{
	var stringUsers = '';
	var users = document.querySelectorAll('input[name="korisnik"]');

	var korisnici = document.querySelector('input[name="korisnici"]');

	users.forEach(function(user)
	{
		if(user.checked)
		{
			if(stringUsers != '')
			{
				stringUsers += ", '" + user.value + "'";
			}
			else
			{
				stringUsers += "'" + user.value + "'";
			}
		}
	});

	if(stringUsers != '')
	{
		users.forEach(function(user)
		{
			user.removeAttribute('required');
		});
	}
	else
	{
		users.forEach(function(user)
		{
			user.setAttribute('required', true);
		});
	}
	korisnici.value = stringUsers;
}

//Preporuka filmova

function OznaciSveKorisnike()
{
	var users = document.querySelectorAll('input[name="korisnik"]');

	users.forEach(function(user)
	{
		user.checked = true;
	});

	document.querySelector('#oznaciKorisnike').style.display = "none";
	document.querySelector('#odznaciKorisnike').style.display = "inline-block";

	CheckboxKorisnici();
}

function OdznaciSveKorisnike()
{
	var users = document.querySelectorAll('input[name="korisnik"]');

	users.forEach(function(user)
	{
		user.checked = false;
	});

	document.querySelector('#oznaciKorisnike').style.display = "inline-block";
	document.querySelector('#odznaciKorisnike').style.display = "none";

	CheckboxKorisnici();	
}