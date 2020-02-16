<?php 
namespace LogParser\classes\Database;

/**
 * Classe responsável por criar as tabelas do banco de dados caso a tabela ainda não exista.
 */
class Schema
{
	
	public function __construct()
	{
		$sql = 'SELECT count(*) FROM GAMES';

	    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
	    try{
	    	gettype(Connection::getInstance()->exec($sql)) == 'integer';
	    }catch (\PDOException $e){
	    	$this->createTables();
	    }
	    return true;
	}

	private function createTables()
	{
		try
		{
			$create_table_games = 'CREATE TABLE IF NOT EXISTS GAMES(
			    game_id integer PRIMARY KEY, 
			    total_kills integer, 
			    time_start text, 
			    time_finish text
			);';

			$create_table_players = 'CREATE TABLE IF NOT EXISTS PLAYERS(
			    player_id integer PRIMARY KEY, 
			    kills integer, 
			    player_name text
			);';

			$create_table_killsbymens = 'CREATE TABLE IF NOT EXISTS KILLSBYMENS(
			    id integer NOT NULL PRIMARY KEY,  
			    kills integer, 
			    player_name text,
			    game_id integer,
			    FOREIGN KEY (game_id) REFERENCES GAMES(game_id)
			);';

			$p_sql = Connection::getInstance()->exec($create_table_games);
			$p_sql = Connection::getInstance()->exec($create_table_players);
			$p_sql = Connection::getInstance()->exec($create_table_killsbymens);
		} 
		catch(PDOException $e)
		{
	        echo $e>getMessage();
		}		
	}
}