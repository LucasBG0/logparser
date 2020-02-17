<!DOCTYPE html>
<html>
<head>
	<title>Log Parser</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="static/css/index.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js" integrity="sha256-R7aNzoy2gFrVs+pNJ6+SokH04ppcEqJ0yFLkNGoFALQ=" crossorigin="anonymous"></script>
</head>
<body>
	<?php require_once('loader_classes.php'); ?>
	<?php use LogParser\classes\Database\Schema; ?>
	<?php $lista_players = Schema::queryAllPlayers(); ?>
	<div class="container">
		<div class="ranking">
			<h1>RANKING</h1>
			<form action="index.php">
				<input type="text" name="searchData" id="search-data"  placeholder="Buscar por nome" autocomplete="off">
				<input type="submit" value="Buscar" id="display-button">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<th>NAME</th>
						<th>
							<img src="static/svg/poison.svg" alt="Poison">KILLS
						</th>				
					</tr>
					<tbody id="inicial-result-container">
						<?php foreach ($lista_players as $key => $player): ?>
						<tr>	
							<td><?php echo $player['player_name']?></td>
							<td<?php echo (boolval($player['kills'] < 0)) ? ' class="negativo"' : '' ?>><?php echo $player['kills']?></td>
						</tr>	
						<?php endforeach; ?>
					</tbody>
					<tbody id="search-result-container" style="display: none"></tbody>					
				</table>				
			</form>				
		</div>		
	</div>
	<?php
	echo '<pre>';
	#print_r($lista_players);
	#print_r($games);
	echo '</pre>';		
	?>
<script>
	// on click search results...
	$(document).on("click", "#display-button" , function(e) {
		 e.preventDefault();
	     var value = $("#search-data").val(); 
	  if (value.length != 0) {
	  //alert(99933);
	        searchData(value);
	    } else {     
	         $('#search-result-container').hide();
	         $('#inicial-result-container').show();
	    }   
	});

	// This function helps to send the request to retrieve data from mysql database...
	function searchData(val)
	{
	 $('#search-result-container').show();
	 $('#inicial-result-container').hide();
	 $('#search-result-container').html('<div><img src="preloader.gif" width="50px;" height="50px"> <span style="font-size: 20px;">Please Wait...</span></div>');
	 $.post('controller.php',{'search-data': val}, function(data){
	     
	  if(data != "")
	   $('#search-result-container').html(data);
	        else    
	  $('#search-result-container').html("<div class='search-result'>No Result Found...</div>");
	 }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
	     
	 alert(thrownError); //alert with HTTP error
	         
	 });
	}
</script>	
</body>
</html>