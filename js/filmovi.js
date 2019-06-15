// $(document).ready(function()
// {
// 	UcitavanjeFilmova();
// });

// function UcitavanjeFilmova()
// {
// 	$.ajax(
// 	{
// 		url: 'action.php?action_id=filmovi_korisnika',
// 		type: 'GET',
// 		success: function(oData)
// 		{
// 			var rbr = 0;
// 			$('.table tbody').empty();
// 			for(var i=0; i<oData.length; i++)
// 			{
// 				rbr+=1;
// 				var sTr = '<tr>'+
// 								'<td>'+rbr+"."+'</td>'+
// 								'<td>'+oData[i].naziv_filma+'</td>'+
// 								'<td>'+oData[i].godina+"."+'</td>'+
// 								'<td>'+oData[i].zanr+'</td>'+
// 								'<td>'+oData[i].moja_ocjena+'</td>'+
// 								'<td onclick="getFilmId('+oData[i].film_id+')"><span class="glyphicon glyphicon-search" onclick="GetModal(\'modals.php?modal_id=edit_employee&film_id='+oData[i].film_id+'\')" aria-hidden="true"></span></td>'+
// 								'<td onclick="getFilmId('+oData[i].film_id+')"><span class="glyphicon glyphicon-trash" onclick="GetModal(\'modals.php?modal_id=obrisi_film&film_id='+oData[i].film_id+'\')" aria-hidden="true"></span></td>'+
// 							'</tr>';
// 				$('.table tbody').append(sTr);
// 				console.log(oData[i].naziv_filma);
// 			}
// 		}
// 	});
// }

function BrisanjeFilma()
{
	$.ajax({
		url:'action.php',
		type: 'POST',
		dataType: 'html',
		data: 
		{
			action_id:'obrisi_film',
			employee_id: localStorage.getItem("film_id"),
			
		},
		success: function(oData)
		{
			$("#modals").modal('hide');
			LoadEmployees();
		},
		error: function(XMLHttpRequest, textStatus, exception)
		{
			console.log("Ajax failure\n" + error);
		},
		async: true
	});
}

function getFilmId(film)
{
	localStorage.setItem("film_id", film)
}
