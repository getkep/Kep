<?php
 
	use KepPHP\Kep\route\Route;
 
	class RouteTest extends PHPUnit_Framework_TestCase {
		
		public function testBasicRoute(){
    		Route::post('teste', function(){
				return "Sucesso";
			});
  		}
		
		public function testRoute(){
			Route::post('testing', ['uses' => 'myController@testing']);
		}
		
	}