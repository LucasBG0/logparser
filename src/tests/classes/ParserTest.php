<?php
namespace LogParser\classes;

/**
 * 
 */

use PHPUnit\Framework\TestCase;
use LogParser\classes\Parser;

class ParserTest extends TestCase
{
	const PARSER_LOG_FILE = 'https://gist.githubusercontent.com/labmorales/7ebd77411ad51c32179bd4c912096031/raw/58ffbba722433c0d47d092f2bcec5ad78777a600/games.log';

	// checa se a classe existe
	public function assertPreConditions():void
	{
		$this->assertTrue(
			class_exists('LogParser\classes\Parser')
		);
	}

	// verificar se o arquivo é um recurso
	public function testLogFileIsResource()
	{
		$parser = new Parser(self::PARSER_LOG_FILE);
		
		$this->assertTrue(
			is_resource($parser->getLogFile())
		);
	}

	//verificar se o método countGames() retorna um array com apenas objetos
	public function testReturnIsObject()
	{
		$parser = new Parser(self::PARSER_LOG_FILE);

		
		$this->assertTrue($this->verifyOnlyObject($parser->countGames()));
	}

	// função auxiliar do método testReturnIsObject()
	private function verifyOnlyObject($games)
	{
		foreach ($games as $game) {
			if (!is_object($game)) {
				return false;
			}
		}
		return true;
	}
}