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
    private static $query;

    /**
     * Query Builder - data selection in the database.
     *
     * @acess public
     *
     * @return array
     */
    public static function select($Query, $parameters, $Order = null)
    {
        self::$query = Grammar::wrapSelect($Query, $parameters, $Order);

        $start = new Connection();
        $start = $start->mysqli();

        $static = $start->mysqli->query(self::$query);
        $result1 = $static->mysqli->num_rows;

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
    public static function update($Query, $parameters)
    {
        self::$query = Grammar::wrapUpdate($Query, $parameters);

        $start = new Connection();
        $start = $start->mysqli();

        $static = $start->mysqli->query(self::$query);
        $result = $start->mysqli->affected_rows;

        return ['affected' => $result];
    }

    /**
     * Query Builder - insert data in the database.
     *
     * @acess public
     *
     * @return array
     */
    public static function insert($Query, $parameters)
    {
        self::$query = Grammar::wrapInsert($Query, $parameters);

        $start = new Connection();
        $start = $start->mysqli();

        $static = $start->mysqli->query(self::$query);
        $result = $start->mysqli->affected_rows;
        $result2 = $start->mysqli->insert_id;

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
    public static function delete($Query, $parameters)
    {
        self::$query = Grammar::wrapDelete($Query, $parameters);

        $start = new Connection();
        $start = $start->mysqli();

        $static = $start->mysqli->query(self::$query);
        $result = $start->mysqli->affected_rows;

        return ['affected' => $result];
    }

    /**
     * Checks if authentication is enabled.
     *
     * @acess public
     *
     * @return array
     */
    public static function isAuth()
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
    public static function authentication()
    {
        $config = parent::getConfig();

        $Column = $config['authentication']['mysqli']['column'];
        $Database = $config['connections']['mysql']['database'];
        $Table = $config['authentication']['mysqli']['table'];

        $result = self::select('SELECT '.$Column.' FROM '.$Database.'.'.$Table.' WHERE '.$Column.'= ?', [$_SESSION['token']]);

        $Date = $result['fetch_array'][0][$Column];

        return $Date;
    }
}
