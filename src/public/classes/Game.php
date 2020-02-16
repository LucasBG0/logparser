<?php

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
	
	function __construct($game_id, $time_start)
	{
		$this->game_id = $game_id;
		$this->time_start = $time_start;
	}

	function addPlayer(Player $player1, Player $player2)
	{
		if ( !$player1 || !$player2 )
			return;

		$assassino = $player1->getName();
		$vitima = $player2->getName();

		// checa se o nome do player existe no atributo players. Se existir, ele não é incluido novamente e a kill do player existente é incrementada.
		if ( !isset($this->kills) ) {

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
		else{
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
		}
	}

	function incrementTotalKills()
	{
		$this->total_kills++;
	}

	function setTimeFinish($time_finish)
	{
		$this->time_finish = $time_finish;
	}
}