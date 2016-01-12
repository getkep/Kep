<?php

namespace KepPHP\Kep\route;

use KepPHP\Kep\kep as Controller;
use Group;

class RouteFactory
{
	/**
	 * Gets past data
	 * 
	 * @acess private
	 * 
	 * @var array
	 */
	private $params;

	/**
	 * Gets the uri
	 * 
	 * @acess private
	 * 
	 * @var string
	 */
	private $request;

	/**
     * Verbs supported by the route.
     *
     * @var array
     */
    private static $verbs = ['GET', 'POST', 'PUT', 'DELETE'];

    function __construct(){
    	$this->getParams();
    	$this->getRequest();
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
		$this->params = json_decode($this->params));
		
        return $this;
	}

	/**
	 * Identify the routes and calls mount.
	 * 
	 * @acess public
	 * 
	 * @return $this
	 */
	public function addRoute(string $HTTP, $endpoint, $action)
	{
		if($HTTP == $this->verbs[0]){
			$this->mountGet($endpoint, $action);

			return $this;
		}elseif($HTTP == $this->verbs[1] or $HTTP == $this->verbs[2] or $HTTP == $this->verbs[3]){
			$this->mountRoute($endpoint, $action);

			return $this;
		}

		return;
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
		if ($this->request == Group::$uri.$endpoint) {
            if (is_array($action)) {
                if (array_key_exists('uses', $action)) {
                    $uses = explode('@', $action['uses']);

                    $this->callController($uses, $this->params);

                    return $this;
                }
            } else {
                $action();
            }
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
            if (is_array($action)) {
                if (array_key_exists('uses', $action)) {
                    $uses = explode('@', $action['uses']);

                    $this->callController($uses, $this->params);

                    return $this;
                }
            } else {
                $action();
            }
        }
	}

	/**
	 * Creation syntax of get the endpoint
	 * 
	 * @acess private
	 * 
	 * @return $this
	 */
	private function wrapGet($endpoint, $action)
	{
		if (strpos($endpoint, ':')) {
            if (strpos($endpoint, '/')) {
                $arrayRequest = explode('/', $this->request;
                $arrayRequest = array_filter($arrayRequest);

                $endpoint = Group::$uri.$endpoint;
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

                return $endpoint;
            } else {
            	return;
            }
        }

        return;
	}

	/**
	 * Passes the parameters to create the controller.
	 * 
	 * @acess private
	 * 
	 * @return $this
	 */
	private function callController($uses, $params)
	{
		$ctrl = new Controller();
		return $ctrl->getController($uses[0], $uses[1], $params);
	}
}