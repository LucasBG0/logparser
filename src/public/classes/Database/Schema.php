<?php 
namespace LogParser\classes\Database;
use \PDO;
use LogParser\classes\Game;

/**
 * Classe responsável por criar as tabelas do banco de dados caso a tabela ainda não exista.
 */
class Schema
{
	public static $instance;

	public static function createAllTables()
	{
		$sql = 'SELECT 1 FROM PLAYERS LIMIT 1';
		$p_sql = Connection::getInstance();
	    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
	    try{
	    	$result = $p_sql->query($sql);
	    }catch (\PDOException $e){
	    	self::createTables();
	    }
	    return;
	}

	private static function createTables()
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
			    player_id integer NOT NULL AUTO_INCREMENT,
			    in_game_id integer, 
			    kills integer, 
			    player_name text,
			    game_id integer,
			    PRIMARY KEY (player_ID),
			    FOREIGN KEY (game_id) REFERENCES GAMES(game_id)
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
	        echo $e->getMessage();
		}		
	}

	public static function setGameDB(Game $game)
	{
		try
		{
			$sql_verify = 'SELECT * FROM Games WHERE game_id=?';
			if (self::checkValueExists($game->getGameId(), $sql_verify))
				return;

			$sql = 'INSERT INTO Games (
				game_id,
				total_kills,
				time_start,
				time_finish)
				VALUES (
				:game_id,
				:total_kills,
				:time_start,
				:time_finish)';
			$p_sql = Connection::getInstance()->prepare($sql);
			$p_sql->bindValue(':game_id', $game->getGameId());
			$p_sql->bindValue(':total_kills', $game->getTotalKills());
			$p_sql->bindValue(':time_start', $game->getTimeStart());
			$p_sql->bindValue(':time_finish', $game->getTimeFinish());
			$result = $p_sql->execute();
			self::setPlayerDB($game);
			return $result;
		}
		catch (\PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public static function setPlayerDB(Game $game)
	{
		$all_players = $game->getKills();
		if (!is_array($all_players))
			return;

		try
		{
			$sql_verify = 'SELECT * FROM Players WHERE player_id=?';
			if (self::checkValueExists(1, $sql_verify))
			{
				#return;
			}

			#die(var_dump($all_players));
			foreach ($all_players as $player) 
			{
				$sql = 'INSERT INTO Players (
					in_game_id,
					kills,
					player_name,
					game_id)
					VALUES (
					:in_game_id,
					:kills,
					:player_name,
					:game_id)';
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->bindValue(':in_game_id', $player->getInGameId());
				$p_sql->bindValue(':kills', $player->getKills());
				$p_sql->bindValue(':player_name', $player->getName());
				$p_sql->bindValue(':game_id', $game->getGameId());
				$result = $p_sql->execute();				
			}
			return $result;
		}
		catch (\PDOException $e)
		{
			echo $e->getMessage();
		}		
	}

	private static function checkValueExists($id, $sql)
	{
		$stmt = $p_sql = Connection::getInstance()->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if( $row)
		{
		    return true;
		}
		return false;
	}
}