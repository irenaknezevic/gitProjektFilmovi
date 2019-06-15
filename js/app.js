var oFilmoviModul = angular.module('filmovi-app', []);

//ZA PRIKAZ DETALJA O FILMU KADA GA API PRONADE (nalazi se u fil_temp.php)
oFilmoviModul.controller('filmoviController', function($scope, $http) {
	$scope.oFilmovi = [];
	$scope.oFilm = [];
	
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

	$scope.spremiFilm = function (imdbID)
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
					// console.log(jsondata);
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
					  data: {"podaciFilma": jsondata},
					  success: function(response){
					  	console.log(response);
					  },
					  dataType: 'json'
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


	}
});

//PRIKAZ FILMOVA KORISNIKA KOJI JE PRIJAVLJEN (nalazi se u filmovi.php)
oFilmoviModul.controller('filmoviTabliceController', function($scope, $http) {
	$scope.oFilmovi = [];

	$http({
		method: "GET",
		url: "http://localhost/action.php?action_id=filmovi_korisnika"
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
		
		var urlPretrage = "http://localhost/action.php?action_id=filmovi_korisnika" + filterZanr + filterOcjena;
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


//ZA PRIKAZ DETALJA O FILMU KOJI JE ODABRAN (prikaz_filma_temp.html)
oFilmoviModul.controller('odabraniFilmController', function($scope, $http) {
	$scope.oFilmovi = [];

	$http({
		method: "GET",
		url: "http://localhost/action.php?action_id=odabrani_film&film_id="+localStorage.getItem("film_id")
	}).then(function(response) {
		console.log(response.data);
		$scope.oFilmovi = response.data;
	},function(response) {
		console.log('Došlo je do pogreške!');
	});
});



function funkcijaOdjava()
{
	document.location = "../odjava.php";
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


function spremiSve()
{
	var e = document.querySelector("#odabir_ocjene");
	var mojaOcjena = e.options[e.selectedIndex].value;
	console.log(mojaOcjena);

	var inputOcjena = document.querySelector("input[name='moja_ocjena']");
	inputOcjena.setAttribute("value", mojaOcjena);
}

//funkcije za dropdown - ocjene i žanr

// function mojaFunkcijaOcjene()
// {
// 	var selectOcjena = document.getElementById("mojaOcjena");
// 	var filterOcjena = selectOcjena.value.toLowerCase();
// 	var table = document.getElementById("mojaTablica");
// 	var oTr = table.getElementsByTagName("tr");
// 	for(var i=0; i<oTr.length; i++)
// 	{
// 		var oTd = oTr[i].getElementsByTagName("td")[4];
// 		if(oTd)
// 		{
// 			if(oTd.innerHTML.toLowerCase().indexOf(filterOcjena) > -1)
// 			{
// 				oTr[i].style.display = "";
// 			}
// 			else 
// 			{
// 				oTr[i].style.display = "none";
// 			}
// 		}
// 	}
// }

// function mojaFunkcijaZanr()
// {
// 	var selectZanr = document.getElementById("mojSelekt");
// 	var filterZanr = selectZanr.value.toLowerCase();
// 	var table = document.getElementById("mojaTablica");
// 	var oTr = table.getElementsByTagName("tr");
// 	for(var i=0; i<oTr.length; i++)
// 	{
// 		var oTd = oTr[i].getElementsByTagName("td")[3];
// 		if(oTd)
// 		{
// 			if(oTd.innerHTML.toLowerCase().indexOf(filterZanr) > -1)
// 			{
// 				oTr[i].style.display = "";
// 			}
// 			else 
// 			{
// 				oTr[i].style.display = "none";
// 			}
// 		}
// 	}
// }

