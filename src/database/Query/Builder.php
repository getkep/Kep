<?php

namespace KepPHP\Kep\database\Query;

use KepPHP\Kep\database\Connection;

class Builder
{
    /**
     * @acess private
     *
     * @var string
     */
    private $table;

    /**
     * @acess private
     *
     * @var string or array 
     */
    private $selects;

    /**
     * @acess private
     *
     * @var string
     */
    private $create;

    /**
     * @acess private
     *
     * @var array
     */
    private $conn;

    public function index($table, $selects = '*')
    {
        $this->conn = new Connection();
        $this->table = (string) $table;
        $this->selects = (string) $selects;

        return $this;
    }

    public function where(array $where = null)
    {
        $Fileds = implode(' = :, ', array_keys($where)).' = :';
        $Places = implode(' = , ', array_keys($where));
        $this->create = $this->create." WHERE {$Fileds}{$Places} ";

        return $this;
    }

    public function limit($limit = null)
    {
        $this->create = $this->create." LIMIT {$limit} ";

        return $this;
    }

    public function order($order = null)
    {
        $this->create = $this->create." ORDER BY {$order} ";

        return $this;
    }

    public function set(array $set)
    {
        $Fileds = implode(' = :, ', array_keys($set)).' = :';
        $Places = implode(' = , ', array_keys($set));
        $this->create = $this->create." {$Fileds}{$Places}";

        return $this;
    }

    public function get()
    {
        return $this->create;
    }

    private function connect()
    {
        // $this->conn = parent::conn();
        // $this->create = $this->conn->prepare($this->create);
    }

    public function selects()
    {
        $this->create = "SELECT {$this->selects} FROM {$this->table}";

        return $this;
    }

    public function updates()
    {
        $this->create = "UPDATE {$this->table} SET";

        return $this;
    }

    public function deletes()
    {
        $this->create = "DELETE FROM {$this->table} ";

        return $this;
    }

    public function inserts()
    {
        $this->create = "INSERT INTO {$this->table}";

        return $this;
    }

    private function syntax()
    {
        $this->create = "SELECT {$this->selects} FROM {$this->table}";
    }
}
