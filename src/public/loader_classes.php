<?php
	error_reporting(-1);
	require_once 'classes/Game.php';
	require_once 'classes/Parser.php';
	require_once 'classes/Player.php';
	require_once 'classes/Database/Connection.php';
	require_once 'classes/Database/Schema.php';
	use LogParser\classes\Database\Schema;	
	Schema::createAllTables();
	use LogParser\classes\Parser;
	$log = 'https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/58ffbba722433c0d47d092f2bcec5ad78777a600/games.log';
	$a = new Parser($log);
	$games = $a->countGames();