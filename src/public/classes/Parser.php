<?php

/**
 * 
 */
class Parser
{
	private $filename;
	private $log_file;
	private $games;
	
	function __construct(string $filename)
	{
		$this->filename = $filename;
		$this->log_file = fopen($filename, 'r');
	}

	function countGames()
	{
		$linha = 1;

		while (!feof($this->log_file)){
			$buffer = fgets($this->log_file, 4096); // lê uma linha do arquivo de log
			
			if ($linha > 1){

				// Incio do jogo
				if(preg_match('/(\d{1,2}:\d{2}) InitGame:/', $buffer, $match_time_start)){
					$game_id++;
					$game = new Game($game_id, $match_time_start[1]);
					$this->games[] = $game;
				}

				// Pega quem matou quem e por qual arma
				if(preg_match('/Kill: \d+\s\d+\s\d+: (<?[\w\s]+>?) killed ([\w\s]+) by (\w+)/', $buffer, $matches)){
					$game->incrementTotalKills();
					$assassino = ($matches[1] == '<world>') ? 'world' : $matches[1];
					$vitima = $matches[2];
					$player1 = new Player($assassino);
					$player2 = new Player($vitima);

					$game->addPlayer($player1, $player2);
				}

				// Fim do jogo
				if(preg_match('/(\d{1,2}:\d{2}) ShutdownGame:/', $buffer))
					$game_finish++;

			}
			$linha++;
		}

		return $this->games;

	}

	function __destruct()
	{
		fclose($this->log_file);
	}
}