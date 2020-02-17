<?php
	require_once('loader_classes.php');
	use LogParser\classes\Database\Schema;
	if( isset($_POST["search-data"]) )
	{
		 $searchVal = trim($_POST["search-data"]);
		 $lista_players = Schema::queryPlayer($searchVal);
		 echo $lista_players;
	}