<?php
namespace LogParser\classes;

/**
 * Classe responsável por armazenar o nome e a quantidade de kills do jogador
 */
class Player
{

	private $name;
	private $kills = 0;
	
	function __construct($name)
	{
		$this->name = $name;
	}

	function incrementKill():void
	{
		$this->kills++;
	}

	function decrementKill():void
	{	
		$this->kills--;
	}

	function getName()
	{
		return $this->name;
	}

	function getKills()
	{
		return $this->kills;
	}

}