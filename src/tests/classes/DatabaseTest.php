<?php
namespace LogParser\classes;

/**
 * 
 */

use PHPUnit\Framework\TestCase;
use LogParser\classes\Database;

class DatabaseTest extends TestCase
{
	
	/** @test */
	public function verificaConexaoBanco()
	{
		$sql = 'SHOW DATABASES';
		$p_sql = Database::getInstace()->query($sql);
		$this->assertTrue(is_object($p_sql));
	}
	
}