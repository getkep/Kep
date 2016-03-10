<?php

namespace KepPHP\Kep\route;

use KepPHP\Kep\controller\CallController as Controller;

class RouteFactory extends Group
{
    /**
     * Gets past data.
     *
     * @acess private
     *
     * @var array
     */
    private $params;

    /**
     * Gets the uri.
     *
     * @acess private
     *
     * @var string
     */
    private $request;

    /**
     * Receives method.
     *
     * @acess private
     *
     * @var string
     */
    private $method;

    /**
     * Verbs supported by the route.
     *
     * @var array
     */
    private $verbs = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

    /**
     * Call the parameters and request.
     *
     * @acess public
     */
    public function __construct()
    {
        $this->getParams();
        $this->getRequest();
        $this->getMethod();
    }

    /**
     * Getting variables for communication.
     *
     * @acess private
     *
     * @return array
     */
    private function getRequest()
    {
        $this->request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;

        return $this;
    }

    /**
     * Search parameters in php:/input and stores.
     *
     * @acess private
     *
     * @return $this
     */
    private function getParams()
    {
        $this->params = file_get_contents('php://input');
        $this->params = json_decode($this->params);

        return $this;
    }

    public function getMethod()
    {
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;

        return $this;
    }

    /**
     * Check the method used by the header with the configured API.
     *
     * @acess public
     *
     * @return $this
     */
    public function addRoute($http, $endpoint, $action)
    {
        if ($this->method == $http) {
            $this->checkMethod($http, $endpoint, $action);
        }
    }

    /**
     * Identify the routes and calls mount.
     *
     * @acess private
     *
     * @return $this
     */
    private function checkMethod($http, $endpoint, $action)
    {
        if ($http == $this->verbs[0]) {
            $this->mountGet($endpoint, $action);
        } elseif ($http == $this->verbs[1] or $http == $this->verbs[2] or $http == $this->verbs[3] or $http == $this->verbs[4]) {
            $this->mountRoute($endpoint, $action);
        }
    }

    /**
     * Riding the routes POST, PUT and DELETE.
     *
     * @acess private
     *
     * @return $this
     */
    private function mountRoute($endpoint, $action)
    {
        if ($this->request == parent::$uri.$endpoint) {
            $this->wrapRoute($action);
        }
    }

    /**
     * Riding the route GET.
     *
     * @acess private
     *
     * @return $this
     */
    private function mountGet($endpoint, $action)
    {
        if ($this->request == '/'.$this->wrapGet($endpoint, $action)) {
            $this->wrapRoute($action);
        }
    }

    /**
     * Checks if it is a closure and separate information to call the controller and action.
     *
     * @acess private
     *
     * @return $this
     */
    private function wrapRoute($action)
    {
        if (is_array($action)) {
            if (array_key_exists('uses', $action)) {
                $this->callController(explode('@', $action['uses']), $this->getFolder($action));
            }
        } else {
            $action();
        }
    }

    /**
     * Check whether there is any folder inside the controller file.
     *
     * @acess private
     *
     * @return string
     */
    private function getFolder($action)
    {
        if (array_key_exists('folder', $action)) {
            return $action['folder'];
        } else {
            return false;
        }
    }

    /**
     * Creation syntax of get the endpoint.
     *
     * @acess private
     *
     * @return $this
     */
    private function wrapGet($endpoint, $action)
    {
        if (strpos($endpoint, ':')) {
            if (strpos($endpoint, '/')) {
                $arrayRequest = explode('/', $this->request);
                $arrayRequest = array_filter($arrayRequest);

                $endpoint = parent::$uri.$endpoint;
                $array = explode('/', $endpoint);
                $array = array_filter($array);

                return $this->mergeEndpoint($array, $arrayRequest);
            } else {
                return;
            }
        }
    }

    /**
     * Merges the endpoint of the index and received by getRequest.
     *
     * @acess private
     *
     * @return string
     */
    private function mergeEndpoint($array, $arrayRequest)
    {
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

        $this->paramsGet($params);

        return implode($replace, '/');
    }

    /**
     * Send params for get.
     *
     * @acess private
     *
     * @return json
     */
    private function paramsGet($params)
    {
        $this->params = json_encode($params);
        $this->params = json_decode($this->params);

        return $this;
    }

    /**
     * Passes the parameters to create the controller.
     *
     * @acess private
     *
     * @return $this
     */
    private function callController($uses, $folder)
    {
        $ctrl = new Controller();

        return $ctrl->getController($uses[0], $uses[1], $this->params, $folder);
    }
}
