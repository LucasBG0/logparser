<!DOCTYPE html>
<html>
<head>
	<title>Log Parser</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="static/css/index.css">
</head>
<body>
	<?php
		error_reporting(-1);
		require_once('loader_classes.php');
		use LogParser\classes\Parser;
		$log = 'https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/58ffbba722433c0d47d092f2bcec5ad78777a600/games.log';
		$a = new Parser($log);
		$a->countGames();
		echo '<pre>';
		#print_r($a->getKillsAllGames());
		#print_r($games);
		echo '</pre>';
	?>
</body>
</html>