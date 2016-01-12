<?php

namespace KepPHP\Kep\database;

use KepPHP\Kep\config\config;
use KepPHP\Kep\database\Query\Builder;

class DB extends config
{
    /**
     * Gets ready query.
     * 
     * @acess private
     */
    private $query;

    /**
     * Query builder v2.
     * 
     * @acess public
     *
     * @return KepPHP\Kep\database\Builder|static
     */
    public function table($table, $selects = '*')
    {
        $Builder = new Builder();

        $Builder->index($table, $selects);

        return $Builder;
    }

    /**
     * Connection to the database - Driver MySQLi.
     *
     * @acess public
     *
     * @return array
     */
    public function db()
    {
        $json = parent::getConfig();

        $conn = new \mysqli($json['connections']['mysql']['host'], $json['connections']['mysql']['username'], $json['connections']['mysql']['password'], $json['connections']['mysql']['database']);
        if (mysqli_connect_errno()) {
            trigger_error(mysqli_connect_error());
        }

        return $conn;
    }

    /**
     * Query Builder - data selection in the database.
     *
     * @acess public
     *
     * @return array
     */
    public function select($Query, $parameters, $Order = null)
    {
        $this->query = Grammar::wrapSelect($Query, $parameters, $Order);

        $start = $this->db();

        $static = $start->query('{$this->query}');
        $result1 = $static->num_rows;

        $result = [];

        while ($fetch = $static->fetch_array(MYSQLI_ASSOC)) {
            $result[] = $fetch;
        }

        $array = [
            'num_rows'    => $result1,
            'fetch_array' => $result,
        ];

        return $array;
    }

    /**
     * Query Builder - data update in the database.
     *
     * @acess public
     *
     * @return array
     */
    public function update($Query, $parameters)
    {
        $this->query = Grammar::wrapUpdate($Query, $parameters);

        $start = $this->db();

        $static = $start->query('{$this->query}');
        $result = $start->affected_rows;

        return ['affected' => $result];
    }

    /**
     * Query Builder - insert data in the database.
     *
     * @acess public
     *
     * @return array
     */
    public function insert($Query, $parameters)
    {
        $this->$query = Grammar::wrapInsert($Query, $parameters);

        $start = $this->db();

        $static = $start->query('{$this->query}');
        $result = $start->affected_rows;
        $result2 = $start->insert_id;

        return [
            'affected'  => $result,
            'insert_id' => $result2,
        ];
    }

    /**
     * Query Builder - delete data in the database.
     *
     * @acess public
     *
     * @return array
     */
    public function delete($Query, $parameters)
    {
        $this->$query = Grammar::wrapDelete($Query, $parameters);

        $start = $this->db();

        $static = $start->query('{$this->query}');
        $result = $start->affected_rows;

        return ['affected' => $result];
    }

    /**
     * Checks if authentication is enabled.
     *
     * @acess public
     *
     * @return array
     */
    public function isAuth()
    {
        $config = parent::getConfig();

        $Active = $config['authentication']['mysqli']['activate'];

        return $Active;
    }

    /**
     * Get the token saved in the database.
     *
     * @acess public
     *
     * @return array
     */
    public function authentication()
    {
        $config = parent::getConfig();

        $Column = $config['authentication']['mysqli']['column'];
        $Database = $config['connections']['mysql']['database'];
        $Table = $config['authentication']['mysqli']['table'];

        $result = $this->select('SELECT '.$Column.' FROM '.$Database.'.'.$Table.' WHERE '.$Column.'= ?', [$_SESSION['token']]);

        $Date = $result['fetch_array'][0][$Column];

        return $Date;
    }
}
