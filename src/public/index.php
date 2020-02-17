<!DOCTYPE html>
<html>
<head>
	<title>Log Parser</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="static/css/index.css">
</head>
<body>
	<?php require_once('loader_classes.php'); ?>
	<?php use LogParser\classes\Database\Schema; ?>
	<?php $lista_players = Schema::queryAllPlayers(); ?>
	<div class="container">
		<div class="ranking">
			<span><a src="#" id="ranking">RANKING</a></span>
			<span><a src="#" id="motivo">MOTIVO DE MORTES</a></span>
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
					<tbody id="inicial-result-container2">
					</tbody>
					<tbody id="search-result-container" style="display: none"></tbody>
					<tbody id="search-result-container2" style="display: none"></tbody>					
				</table>				
			</form>				
		</div>		
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js" integrity="sha256-R7aNzoy2gFrVs+pNJ6+SokH04ppcEqJ0yFLkNGoFALQ=" crossorigin="anonymous"></script>
	<script language="JavaScript" type="text/javascript" src="static/js/index.js"></script>	
</body>
</html>