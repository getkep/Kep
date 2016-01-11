<?php

namespace KepPHP\Kep\database;

use KepPHP\Kep\config\config;

class Connection
{
	/**
     * The active PDO connection.
     *
     * @var PDO
     */
	protected $pdo;

	/**
     * Create a new database connection instance.
     *
     * @return PDO
     */
	public function __construct()
	{
		$config = config::getConfig();
		$config = $config['connections'];

		$this->pdo = new PDO($config['driver'].':host='.$config['host'].';dbname='.$config['database'], $config['username'], $config['password']);
	
		return $this;
	}
}