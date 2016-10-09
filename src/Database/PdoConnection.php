<?php

namespace KepPHP\Kep\Database;

use KepPHP\Kep\config\Config;

class PdoConnection
{
	/**
     * Configuration.
     *
     * @var array
     */
	private $config;

	/**
     * Return connection settings.
     *
     * @return config
     */
	public function getConfig()
	{
		$this->config = config::getConfig();
        $this->config = $this->config['connections'];

        return $this;
	}

	/**
     * Create a new database connection instance.
     *
     * @return PDO
     */
	public function pdo()
	{
		return new PDO($this->config['driver'].':host='.$this->config['host'].';dbname='.$this->config['database'], $this->config['username'], $this->config['password']);
	}
}