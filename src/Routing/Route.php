<?php

namespace Kep\Routing;

use Kep\Routing\RouteFactory as Factory;

class Route extends Group
{
    /**
     * POST interprets the communication and calls the controller if there.
     *
     * @acess public
     */
    public static function post($endpoint, $function)
    {
        $Factory = new Factory();

        return $Factory->addRoute('POST', $endpoint, $function);
    }

    /**
     * Interprets the GET communication and calls the controller if there.
     *
     * @acess public
     */
    public static function get($endpoint, $function)
    {
        $Factory = new Factory();

        return $Factory->addRoute('GET', $endpoint, $function);
    }

    /**
     * Interprets the PUT communication and calls the controller if there.
     *
     * @acess public
     */
    public static function put($endpoint, $function)
    {
        $Factory = new Factory();

        return $Factory->addRoute('PUT', $endpoint, $function);
    }

    /**
     * DELETE interprets the communication and calls the controller if there.
     *
     * @acess public
     */
    public static function delete($endpoint, $function)
    {
        $Factory = new Factory();

        return $Factory->addRoute('DELETE', $endpoint, $function);
    }

    /**
     * PATCH interprets the communication and calls the controller if there.
     *
     * @acess public
     */
    public static function patch($endpoint, $function)
    {
        $Factory = new Factory();

        return $Factory->addRoute('PATCH', $endpoint, $function);
    }
}
