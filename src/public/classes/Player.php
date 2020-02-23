<?php
namespace LogParser\classes;

use LogParser\classes\Database\Schema;

/**
 * Classe responsável por armazenar o nome e a quantidade de kills do jogador
 */
class Player
{

	private $player_name;
	private $kills = 0;
	private $in_game_id = 0;
	
	public function __construct($player_name, $player_id)
	{
		$this->player_name = $player_name;
		$this->in_game_id = $player_id;
	}

	public function incrementKill():void
	{
		$this->kills++;
	}

	public function decrementKill():void
	{	
		$this->kills--;
	}

	public function getName()
	{
		return $this->player_name;
	}

	public function getKills()
	{
		return $this->kills;
	}

	public function getInGameId()
	{
		return $this->in_game_id;
	}

	public static function viewPlayerItem()
	{
		$lista_players = Schema::queryAllPlayers();
		$html = file_get_contents('static/html/player_item.html');
		$items = '';

		foreach ($lista_players as $player) {
			
			$item = str_replace('{player_name}', $player->player_name, $html);
			$item = str_replace('{kills}', $player->kills, $item);
			if ($player->kills < 0) 
			{
				$item = str_replace('{classe}', ' class="negativo"', $item);
			}else
			{
				$item = str_replace('{classe}', '', $item);
			}	
			$items .= $item;
		}

		return $items;
	}

}