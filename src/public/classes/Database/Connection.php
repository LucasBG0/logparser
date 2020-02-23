<?php
namespace LogParser\classes\Database;
use \PDO;

/**
 * Classe responsável pela conexão com o banco de dados
 */
class Connection
{

	public static $instance;
	private static $dbname;
	private static $user;
	private static $password;
	// host é o nome do container do mysql
	private static $host;

    public static function getInstance() 
    {
        if (!isset(self::$instance)) 
        {
            self::$dbname = getenv('MYSQL_DATABASE');
            self::$user = getenv('MYSQL_USER');
            self::$password = getenv('MYSQL_PASSWORD');
            self::$host = getenv('MYSQL_HOST');

            self::$instance = new PDO(
            	'mysql:host=' . self::$host . ';dbname=' . self::$dbname, 
            	self::$user, 
            	self::$password, 
            	array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );

            self::$instance->setAttribute(
            	PDO::ATTR_ERRMODE, 
            	PDO::ERRMODE_EXCEPTION
            );
            
            self::$instance->setAttribute(
            	PDO::ATTR_ORACLE_NULLS, 
            	PDO::NULL_EMPTY_STRING
            );

            self::$instance->setAttribute(
            	PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true
            );
        }
  
        return self::$instance;
    }
}