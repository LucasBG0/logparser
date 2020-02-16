<?php
namespace LogParser\classes;

/**
 * Classe responsável por percorrer o arquivo de log e identificar os dados de jogo
 */
class Parser
{
	private $filename;
	private $log_file;
	private $games;
	
	public function __construct(string $filename)
	{
		$this->filename = $filename;
		$this->log_file = fopen($filename, 'r');
	}

	public function countGames()
	{
		$linha = 1;
		$game_id = 0;

		while ( !feof($this->log_file) )
		{
			$buffer = fgets($this->log_file, 4096); // lê uma linha do arquivo de log
			
			if ( $linha > 1 )
			{
				// Incio do jogo
				if ( preg_match('/(\d{1,3}:\d{2}) InitGame:/', $buffer, $match_time_start) )
				{
					$game_id++;
					$game = new Game($game_id, $match_time_start[1]);
					$this->games[] = $game;
				}

				// Quem matou quem e por qual arma
				if( preg_match('/Kill: \d+\s\d+\s\d+: (<?[\w\s]+>?) killed ([\w\s]+) by (\w+)/', $buffer, $matches_players_and_gun) )
				{
					$game->incrementTotalKills();

					$assassino = ($matches_players_and_gun[1] == '<world>') ? 'world' : $matches_players_and_gun[1];
					$vitima = $matches_players_and_gun[2];
					$motivo_morte = $matches_players_and_gun[3];
					$player1 = new Player($assassino);
					$player2 = new Player($vitima);
					$game->setKillsByMens( new Player($motivo_morte) );

					// método responsável pela mecânica de incrementar e decrementar as kills
					$game->addPlayer($player1, $player2);
				}

				// Fim do jogo
				if( preg_match('/(\d{1,3}:\d{2}) ShutdownGame:/', $buffer, $match_time_finish) )
					$game->setTimeFinish($match_time_finish[1]);

			}
			$linha++;
		}

		return $this->games;

	}

	public function getLogFile()
	{
		return $this->log_file;
	}

	public function __destruct()
	{
		fclose($this->log_file);
	}
}