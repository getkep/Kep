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
     * The active MySQLi connection.
     *
     * @var MYSQLI
     */
    public $mysqli;

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
    public function __construct()
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
        $this->pdo = new PDO($this->config['driver'].':host='.$this->config['host'].';dbname='.$this->config['database'], $this->config['username'], $this->config['password']);

        return $this;
    }

    /**
     * Create a new database connection instance.
     *
     * @return MYSQLI
     */
    public function mysqli()
    {
        $this->mysqli = new \mysqli($this->config['host'], $this->config['username'], $this->config['password'], $this->config['database']);

        return $this;
    }
}
