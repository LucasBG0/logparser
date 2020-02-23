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
	$log = 'logs/games.log';
	$a = new Parser($log);
	$games = $a->countGames();