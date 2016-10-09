<?php

namespace KepPHP\Kep\Database;

use KepPHP\Kep\config\Config;

class MysqlConnection
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
     * @return MYSQLI
     */
    public function mysql()
    {
        return new \mysqli($this->config['host'], $this->config['username'], $this->config['password'], $this->config['database']);
    }
}
