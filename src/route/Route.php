<?php

namespace KepPHP\Kep\route;

use KepPHP\Kep\kep;

    class Route extends Group
    {
        /**
         * Getting variables for communication.
         *
         * @acess public
         *
         * @return array
         */
        public static function request()
        {
            return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
        }

        /**
         * POST interprets the communication and calls the controller if there.
         *
         * @acess public
         */
        public static function post($endpoint, $function)
        {
            if (self::request() == self::$uri.$endpoint) {
                if (is_array($function)) {
                    if (array_key_exists('uses', $function)) {
                        $uses = explode('@', $function['uses']);

                        $Post = file_get_contents('php://input');
                        $params = json_decode($Post);

                        $kep = new kep();
                        $kep->getController($uses[0], $uses[1], $params);
                    }
                } else {
                    $function();
                }
            }
        }

        /**
         * Interprets the GET communication and calls the controller if there.
         *
         * @acess public
         */
        public static function get($endpoint, $function)
        {
            if (strpos($endpoint, ':')) {
                if (strpos($endpoint, '/')) {
                    $arrayRequest = explode('/', self::request());
                    $arrayRequest = array_filter($arrayRequest);

                    $endpoint = self::$uri.$endpoint;
                    $array = explode('/', $endpoint);
                    $array = array_filter($array);

                    $n = 1;
                    foreach ($array as $add) {
                        $var = substr($add, 0, 1);
                        if ($var == ':') {
                            $params[str_replace(':', '', $add)] = $arrayRequest[$n];
                            $uri1[] = $add;
                            $uri3[] = $arrayRequest[$n];
                        } else {
                            $uri2[] = $add;
                        }

                        $n++;
                    }

                    $replace = str_replace($uri1, $uri3, $array);
                    $endpoint = implode($replace, '/');
                } else {
                }
            }

            if (self::request() == '/'.$endpoint) {
                if (is_array($function)) {
                    if (array_key_exists('uses', $function)) {
                        $uses = explode('@', $function['uses']);

                        $kep = new kep();
                        $kep->getController($uses[0], $uses[1], $params);
                    }
                } else {
                    $function();
                }
            }
        }

        /**
         * Interprets the PUT communication and calls the controller if there.
         *
         * @acess public
         */
        public static function put($endpoint, $function)
        {
            if (self::request() == self::$uri.$endpoint) {
                if (is_array($function)) {
                    if (array_key_exists('uses', $function)) {
                        $uses = explode('@', $function['uses']);

                        $Post = file_get_contents('php://input');
                        $params = json_decode($Post);

                        $kep = new kep();
                        $kep->getController($uses[0], $uses[1], $params);
                    }
                } else {
                    $function();
                }
            }
        }

        /**
         * DELETE interprets the communication and calls the controller if there.
         *
         * @acess public
         */
        public static function delete($endpoint, $function)
        {
            if (self::request() == self::$uri.$endpoint) {
                if (is_array($function)) {
                    if (array_key_exists('uses', $function)) {
                        $uses = explode('@', $function['uses']);

                        $Post = file_get_contents('php://input');
                        $params = json_decode($Post);

                        $kep = new kep();
                        $kep->getController($uses[0], $uses[1], $params);
                    }
                } else {
                    $function();
                }
            }
        }
    }
