<?php

namespace KepPHP\Kep;

/**
     * @name Kep Micro-Framework
     *
     * @author Matuzalém S. Teles <matuzalemteles@gmail.com>
     *
     * @link http://getkep.com official website of Kep Framework for PHP
     *
     * @copyright 2016 Kep Framework
     */

    // ============================================================================ //
    // Class
    // ============================================================================ //

    class kep
    {
        /**
         * @acess private
         *
         * @var string Receives the controller name
         */
        private $controller;

        /**
         * @acess private
         *
         * @var string Receives the function to start
         */
        private $action;

        /**
         * @acess private
         *
         * @var array or json 	Parameters to be passed
         */
        private $parameters;

        /**
         * @acess private
         *
         * @var string Returns false or true
         */
        private $auth;

        /**
         * @acess private
         * 
         * @var string Path
         */
        private $path;

        /**
         * Mount the controller to perform the actions requested by the route.
         *
         * @acess public
         *
         * @return action returns the function called by route
         */
        public function createController()
        {
            $directory = new \KepPHP\Kep\config\config();
            $directory = $directory->getConfig();
            $directory = $directory['directory'];

            $this->path = '../'.$directory.'/controllers/'.$this->controller.'.php';

            $this->checkController();

            return;
        }

        /**
         * Check if the controller parameter exist or is empty.
         *
         * @acess private
         *
         * @param string $Path controller path
         */
        private function checkController()
        {
            if (!$this->controller) {
                $this->responseJson('Controller does not exist.'.$this->controller, 404);

                return;
            }

            $this->checkPatchController();
        }

        /**
         * Check if the controller of the way there.
         *
         * @acess private
         *
         * @param string $Path controller path
         */
        private function checkPatchController()
        {
            if (!file_exists($this->path)) {
                $this->responseJson('We did not find the driver: '.$this->path.' '.$this->params, 404);

                return;
            }

            $this->checkClassController();
        }

        /**
         * Check if the driver class exists.
         *
         * @acess private
         *
         * @param string $Path controller path
         */
        private function checkClassController()
        {
            require_once $this->path;

            if (!class_exists($this->controller)) {
                $this->responseJson('We did not find the driver class', 404);

                return;
            }

            $this->controller = new $this->controller($this->parameters);

            $this->checkMethodController();
        }

        /**
         * Check if the method exists.
         *
         * @acess private
         */
        private function checkMethodController()
        {
            if (method_exists($this->controller, $this->action)) {
                $this->controller->{$this->action}($this->parameters);

                return;
            }

            $this->checkActionController();
        }

        /**
         * Make sure that the class called function exist in the controller.
         *
         * @acess private
         */
        private function checkActionController()
        {
            if (!$this->action && method_exists($this->controlador, 'index')) {
                $this->controller->index($this->parameters);

                return;
            }

            $this->responseJson('We did not find the controller', 404);
        }

        /**
         * function to return a message in json.
         *
         * @acess private
         *
         * @param string $Message error message
         * @param int    $Code    Error code
         *
         * @return string Error message in JSON
         */
        private function responseJson($Message, $Code)
        {
            $array = [
                'status'  => 'error',
                'message' => $Message,
                'code'    => $Code,
            ];

            echo json_encode($array);
        }

        /**
         * checks for user authentication.
         *
         * @acess public
         *
         * @param string $Name  Username
         * @param string $Token Token Authentication
         *
         * @return int returns true or false
         */
        public function isAuth($Name, $Token)
        {
            $auth = new authentication\auth();

            $check = $auth->checkToken($Name, $Token);

            if ($check == 'disabled') {
                return true;
            } elseif ($check == 'true') {
                return true;
            } elseif ($check == 'false') {
                return false;
            }
        }

        /**
         * Run function calls the function createController().
         *
         * @acess public
         *
         * @param string      $controller
         * @param string      $action
         * @param array||json $params
         */
        public function getController($controller, $action, $params)
        {
            $this->controller = $controller;
            $this->action = $action;
            $this->parameters = $params;

            if (isset($params->user) && isset($params->token)) {
                if ($this->isAuth($params->user, $params->token) == true) {
                    $this->createController();
                } else {
                    $this->responseJson('Authentication failed', 404);
                }
            } else {
                $this->createController();
            }
        }
    }
