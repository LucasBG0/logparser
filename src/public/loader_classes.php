<?php
	error_reporting(-1);
	require_once 'classes/Game.php';
	require_once 'classes/Parser.php';
	require_once 'classes/Player.php';
	require_once 'classes/Database/Connection.php';
	require_once 'classes/Database/Schema.php';
	LogParser\classes\Database\Schema::createAllTables();
	$log = 'logs/games.log';
	$a = new LogParser\classes\Parser($log);
	$games = $a->countGames();