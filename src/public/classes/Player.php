<?php
namespace LogParser\classes;

/**
 * Classe responsável por armazenar o nome e a quantidade de kills do jogador
 */
class Player
{

	private $name;
	private $kills = 0;
	
	public function __construct($name)
	{
		$this->name = $name;
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
		return $this->name;
	}

	public function getKills()
	{
		return $this->kills;
	}

}