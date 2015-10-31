<?php
 
	use KepPHP\Kep\route\Route;
 
	class RouteTest extends PHPUnit_Framework_TestCase {
		
		public function testBasicRoute(){
    		Route::post('teste', function(){
				return "Sucesso";
			});
  		}
		
		public function testRoutePost(){
			Route::post('testing', ['uses' => 'myController@testing']);
		}
		
		public function testRouteGet(){
			Route::get('get', ['uses' => 'myController@get']);
		}
		
		public function testRoutePut(){
			Route::put('put', ['uses' => 'myController@put']);
		}
		
		public function testRouteDelete(){
			Route::delete('delete', ['uses' => 'myController@delete']);
		}
		
	}