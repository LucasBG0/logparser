<?php
	require_once('loader_classes.php');
	use LogParser\classes\Database\Schema;
	if( isset($_POST["search-ranking"]) )
	{	
		 $searchVal = trim($_POST["search-ranking"]);
		 $lista_players = Schema::queryPlayer($searchVal, 'players');
		 echo $lista_players;
	}

	if( isset($_POST["search-motivo"]) )
	{
		 $killsByMens = Schema::queryAllKillsByMens();
		 echo $killsByMens;
	}

	if( isset($_POST["search-motivo"]) && $_POST['search-data'] == 'ranking' )
	{
		$searchVal = trim($_POST["search-motivo"]);
		 $killsByMens = Schema::queryPlayer($searchVal, 'killsbymens');
		 echo $killsByMens;
	}

