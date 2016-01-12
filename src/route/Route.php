<?php

namespace KepPHP\Kep\route;

use RouteFactory as Factory;

    class Route extends Group
    {
        /**
         * POST interprets the communication and calls the controller if there.
         *
         * @acess public
         */
        public static function post($endpoint, $function)
        {
            return Factory::addRoute('POST', $endpoint, $function);
        }

        /**
         * Interprets the GET communication and calls the controller if there.
         *
         * @acess public
         */
        public static function get($endpoint, $function)
        {
            return Factory::addRoute('GET', $endpoint, $function);
        }

        /**
         * Interprets the PUT communication and calls the controller if there.
         *
         * @acess public
         */
        public static function put($endpoint, $function)
        {
            return Factory::addRoute('PUT', $endpoint, $function);
        }

        /**
         * DELETE interprets the communication and calls the controller if there.
         *
         * @acess public
         */
        public static function delete($endpoint, $function)
        {
            return Factory::addRoute('DELETE', $endpoint, $function);
        }
    }
