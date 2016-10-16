<?php

namespace Kep\Routing;

class Group
{
    /**
     * @acess private
     *
     * @var string
     */
    public static $uri;

    /**
     * Responsible to record the group name.
     *
     * @param string $prefix
     * @acess private
     */
    private static function prefix($prefix)
    {
        return self::$uri = '/'.$prefix.'/';
    }

    /**
     * Create group.
     *
     * @param string $prefix
     * @param $function
     * @acess public
     */
    public static function group($prefix, $function)
    {
        self::prefix($prefix);
        $function();
    }
}
