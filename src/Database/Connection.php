<?php

namespace KepPHP\Kep\Database;

use MysqlConnection;
use PdoConnection;

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
    private $mysql;

    /**
     * Call PDO connection class.
     *
     * @return PDO
     */
    public function pdo()
    {
        $this->pdo = PdoConnection::pdo();

        return $this;
    }

    /**
     * Call MYSQLI connection class.
     *
     * @return MYSQLI
     */
    public function mysqli()
    {
        $this->mysql = MysqlConnection::mysql();

        return $this->mysql;
    }
}
