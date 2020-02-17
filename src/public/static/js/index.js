// on click search results...
$(document).on("click", "#display-button" , function(e) {
	 e.preventDefault();
     var value = $("#search-data").val(); 
  if (value.length != 0) {
  //alert(99933);
     searchData(value);
    } else {     
         $('#search-result-container').hide();
    }   
});

// on click search results...
$(document).on("click", "#display-button-motivo" , function(e) {
	 e.preventDefault();
     var value = $("#search-data").val(); 
  if (value.length != 0) {
  //alert(99933);
     	searchMotivo(value);
    } else {     
         $('#search-result-container2').hide();
    }   
});

// on click motivo de mortes results...
$(document).on("click", "#motivo" , function(e) {
	 e.preventDefault();
     var value = 'motivo';
     var campo = 'search-data';
     //$('#display-button').prev('#display-button').prop('id', 'display-button-motivo');
     $("#display-button").prop('id', 'display-button-motivo');
     $('#inicial-result-container2').show();
     $('#inicial-result-container').hide();
     $('#search-result-container').hide();
     searchMotivo(value);
});

// on click ranking results...
$(document).on("click", "#ranking" , function(e) {
	 e.preventDefault();
	 $("#display-button-motivo").prop('id', 'display-button');
	 $('#inicial-result-container').show();
	 $('#search-result-container2').hide();
});

// This function helps to send the request to retrieve data from mysql database...
function searchData(val)
{
 $('#inicial-result-container').hide();
 $('#search-result-container').show();
 $('#search-result-container').html('<div><img src="static/img/loading1.gif" width="120px;"> <span style="font-size: 20px;">Aguarde...</span></div>');
 $.post('controller.php',{'search-ranking': val}, function(data){
     
  if(data != "")
   $('#search-result-container').html(data);
        else    
  $('#search-result-container').html("<div class='search-result'>Nenhum resultado encontrado...</div>");
 }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
     
 alert(thrownError); //alert with HTTP error
         
 });
}

function searchMotivo(val)
{
 $('#inicial-result-container2').hide();
 $('#search-result-container2').show();
 $('#search-result-container2').html('<div><img src="static/img/loading1.gif" width="120px;"> <span style="font-size: 20px;">Aguarde...</span></div>');
 $.post('controller.php',{'search-motivo': val}, function(data){
     
  if(data != "")
   $('#search-result-container2').html(data);
        else    
  $('#search-result-container2').html("<div class='search-result'>Nenhum resultado encontrado...</div>");
 }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
     
 alert(thrownError); //alert with HTTP error
         
 });
}