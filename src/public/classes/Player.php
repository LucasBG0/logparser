<?php

/**
 * 
 */
class Player
{

	private $name;
	private $kills = 0;
	
	function __construct($name)
	{
		$this->name = $name;
	}

	function incrementKill()
	{
		$this->kills++;
	}

	function decrementKill()
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