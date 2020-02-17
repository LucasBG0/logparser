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
			<h1>RANKING</h1>
			<form action="index.php">
				<input type="text" name="busca" placeholder="Buscar por nome">
				<input type="submit" value="Buscar">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<th>NAME</th>
						<th>
							<img src="static/svg/poison.svg" alt="Poison">KILLS
						</th>				
					</tr>
					<?php foreach ($lista_players as $key => $player): ?>
					<tr>	
						<td><?php echo $player['player_name']?></td>
						<td<?php echo (boolval($player['kills'] < 0)) ? ' class="negativo"' : '' ?>><?php echo $player['kills']?></td>
					</tr>	
					<?php endforeach; ?>	
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
</body>
</html>