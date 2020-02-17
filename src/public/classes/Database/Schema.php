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
			    id integer NOT NULL AUTO_INCREMENT,  
			    kills integer, 
			    player_name text,
			    game_id integer,
			    PRIMARY KEY (id),
			    FOREIGN KEY (game_id) REFERENCES GAMES(game_id)
			);';

			$p_sql = Connection::getInstance()->exec($create_table_games);
			$p_sql = Connection::getInstance()->exec($create_table_players);
			$p_sql = Connection::getInstance()->exec($create_table_killsbymens);
		} 
		catch(\PDOException $e)
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
			self::setKillsByMensDB($game);
			return $result;
		}
		catch (\PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	private static function setPlayerDB(Game $game)
	{
		$all_players = $game->getKills();
		if (!is_array($all_players))
			return;

		try
		{				
			foreach ($all_players as $player) 
			{
				
				// verifica se o player existe. Se existir, altera a linha existente. Se não existir, cria uma nova entrada.
				$sql_verify = 'SELECT kills, player_id FROM players WHERE player_name = :player_name';
				$p_sql = Connection::getInstance()->prepare($sql_verify);
				$p_sql->bindValue(":player_name", $player->getName());
				$p_sql->execute();
				$player_result = $p_sql->fetch(PDO::FETCH_ASSOC);
				if( $player_result )
				{
					$sql_update = 'UPDATE PLAYERS SET KILLS = :old_kills + :new_kills WHERE player_id = :player_id';
					$pdo_update = Connection::getInstance()->prepare($sql_update);
					$pdo_update->bindValue(":old_kills", $player_result['kills']);
					$pdo_update->bindValue(":new_kills", $player->getKills());
					$pdo_update->bindValue(":player_id", $player_result['player_id']);
					$pdo_update->execute();
					continue;
				}

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
		}
		catch (\PDOException $e)
		{
			echo $e->getMessage();
		}		
	}

	private static function setKillsByMensDB(Game $game)
	{
		$kills_by_mens = $game->getKillsByMens();
		if (!is_array($kills_by_mens))
			return;

		try
		{
			foreach ($kills_by_mens as $arma) 
			{
				// verifica se a entrada existe. Se existir, altera a linha existente. Se não existir, cria uma nova entrada.
				$sql_verify = 'SELECT kills, id FROM killsbymens WHERE player_name = :player_name';
				$p_sql = Connection::getInstance()->prepare($sql_verify);
				$p_sql->bindValue(":player_name", $arma->getName());
				$p_sql->execute();
				$arma_result = $p_sql->fetch(PDO::FETCH_ASSOC);
				if( $arma_result )
				{
					$sql_update = 'UPDATE killsbymens SET KILLS = :old_kills + :new_kills WHERE id = :id';
					$pdo_update = Connection::getInstance()->prepare($sql_update);
					$pdo_update->bindValue(":old_kills", $arma_result['kills']);
					$pdo_update->bindValue(":new_kills", $arma->getKills());
					$pdo_update->bindValue(":id", $arma_result['id']);
					$pdo_update->execute();
					continue;
				}				
				$sql = 'INSERT INTO KILLSBYMENS (
					kills,
					player_name,
					game_id)
					VALUES (
					:kills,
					:player_name,
					:game_id)';
				$p_sql = Connection::getInstance()->prepare($sql);
				$p_sql->bindValue(':kills', $arma->getKills());
				$p_sql->bindValue(':player_name', $arma->getName());
				$p_sql->bindValue(':game_id', $game->getGameId());
				$result = $p_sql->execute();				
			}
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

		if($row)
		{
		    return $row;
		}
		return false;
	}

	public static function queryAllPlayers()
	{
		try 
		{
			$sql = 'SELECT player_name, kills FROM players ORDER BY KILLS DESC';
			$result = Connection::getInstance()->query($sql);
			$lista = $result->fetchAll(PDO::FETCH_ASSOC);
			
			//remove world da listagem
			foreach ($lista as $key => $value) {
				if ($value['player_name'] === 'world') {
					unset($lista[$key]);
					break;
				}
			}

			return $lista;
		} 
		catch (Exception $e) 
		{
		echo $e->getMessage();
		}		
	}

	public static function queryPlayer($player_name)
	{
		try 
		{
			$sql = 'SELECT player_name, kills FROM players WHERE player_name like :player_name';
			$stmt = Connection::getInstance()->prepare($sql);
			$val = "%$player_name%"; 
			$stmt->bindParam(':player_name', $val , PDO::PARAM_STR); 			
			$stmt->execute();
			$Count = $stmt->rowCount(); 
			//echo " Total Records Count : $Count .<br>" ;
			     
			$result ="" ;
			if ($Count  > 0)
			{
				while($data=$stmt->fetch(PDO::FETCH_ASSOC)) 
				{
					$negativo = (boolval($data['kills'] < 0)) ? ' class="negativo"' : '';
					$result = $result .'<tr><td>' . $data['player_name'] . '
					</td><td'.$negativo . '>' . $data['kills'] . '</td></tr>';					  
				}
			return $result;
			}
			
		} 
		catch (PDOException $e) 
		{
		echo $e->getMessage();
		}			
	}

	public static function queryAllKillsByMens()
	{
		try 
		{
			$sql = 'SELECT game_id, sum(kills) FROM KILLSBYMENS GROUP BY player_name';
			$result = Connection::getInstance()->query($sql);
			$lista = $result->fetchAll(PDO::FETCH_ASSOC);
			return $lista;
		} 
		catch (Exception $e) 
		{
		echo $e->getMessage();
		}
	}
}