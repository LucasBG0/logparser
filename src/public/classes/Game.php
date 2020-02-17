<?php
namespace LogParser\classes;
use LogParser\classes\Database\Schema;
/**
 * Classe responsável por armazenar os dados do jogo
 */
class Game
{
	private $game_id = 0;
	private $total_kills = 0;
	private $players;
	private $kills;
	private $time_start;
	private $time_finish;
	private $kills_by_mens;
	
	public function __construct($game_id, $time_start)
	{
		$this->game_id = $game_id;
		$this->time_start = $time_start;
	}

	public function addPlayer(Player $player1, Player $player2):void
	{
		if ( !$player1 || !$player2 )
			return;

		$assassino = $player1->getName();
		$vitima = $player2->getName();

		// checa se o nome do player existe no atributo kills. Se existir, ele não é incluido novamente e a kill do player existente é incrementada.
		if ( isset($this->kills) ) {
			foreach ( $this->kills as &$player )
			{
				if ( $assassino != $vitima && $player->getName() == $assassino )				
					$player->incrementKill();

				if ( $assassino == 'world' && $player->getName() == $vitima)
					$player->decrementKill();

				if ( !in_array($assassino, $this->players) )
				{
					$this->players[] = $assassino;
					$this->kills[] = $player1;
				}
				if ( !in_array($vitima, $this->players) )
				{
					$this->players[] = $vitima;
					$this->kills[] = $player2;
				}				
			}
			return;
		}

		if ( $assassino != $vitima )
		{					
			$player1->incrementKill();
		}

		if ( $assassino == 'world' )
		{
			$player2->decrementKill();
		}

		$this->kills[] = $player1;
		$this->kills[] = $player2;
		$this->players[] = $assassino;
		$this->players[] = $vitima;			
	}

	public function incrementTotalKills():void
	{
		$this->total_kills++;
	}

	public function setTimeFinish($time_finish):void
	{
		$this->time_finish = $time_finish;
	}

	// Checa se o motivo da morte já existe no atributo kills_by_mens, se existir, as kills desse objeto é incrementada.
	public function setKillsByMens(Player $k)
	{
		if ( isset($this->kills_by_mens) ) 
		{
			foreach ($this->kills_by_mens as &$motivo_morte) 
			{
				if ($motivo_morte->getName() == $k->getName())
				{
					$motivo_morte->incrementKill();
					return;						
				}
			}
		}
		$k->incrementKill();
		$this->kills_by_mens[] = $k;		
	}

	public function getKillsByMens()
	{
		return $this->kills_by_mens;
	}

	public function getGameId()
	{
		return $this->game_id;
	}

	public function getTotalKills()
	{
		return $this->total_kills;
	}

	public function getTimeStart()
	{
		return $this->time_start;
	}

	public function getTimeFinish()
	{
		return $this->time_finish;
	}

	public function getKills()
	{
		return $this->kills;
	}
}