<?php
namespace LogParser\classes;

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

}