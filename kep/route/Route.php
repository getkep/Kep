<?php
	namespace KepPHP\Kep\route;
	
	class Route extends Group{
		
		/**
		* Recebendo variaveis para comunicação.
		* @acess public
		* @return array
		*/
		public static function request(){
			return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
		}
		
		/**
		* Interpreta a comunicação POST e chama o controller se houver 
		* @acess public
		*/
		public static function post($endpoint, $function){
			if(self::request() == self::$uri.$endpoint){
				if(is_array($function)){
					if(array_key_exists("uses", $function)){
						$uses = explode("@", $function['uses']);
						
						$Post = file_get_contents("php://input");
						$params = json_decode($Post);

						$kep = new \kep();
						$kep->getController($uses[0], $uses[1], $params);
					}
				}else{
					$function();
				}
			}
		}
		
		/**
		* Interpreta a comunicação GET e chama o controller se houver 
		* @acess public
		*/
		public static function get($endpoint, $function){
			if(strpos($endpoint, ":")){
				if(strpos($endpoint, "/")){
					$arrayRequest = explode('/', self::request());
					$arrayRequest = array_filter($arrayRequest);

					$endpoint = self::$uri.$endpoint;
					$array  = explode('/', $endpoint);
					$array = array_filter($array);

					$n = 1;
					foreach ($array as $add) {
						$var = substr($add, 0, 1);
						if($var == ":"){
							$params[str_replace(":", "", $add)] = $arrayRequest[$n];
							$uri1[] = $add;
							$uri3[] = $arrayRequest[$n];
						}else{
							$uri2[] = $add;
						}

						$n++;
					}

					$replace = str_replace($uri1, $uri3, $array);
					$endpoint = implode($replace, "/");
				}else{

				}
			}

			if(self::request() == "/".$endpoint){
				if(is_array($function)){
					if(array_key_exists("uses", $function)){
						$uses = explode("@", $function['uses']);
						
						$kep = new \kep();
						$kep->getController($uses[0], $uses[1], $params);
					}
				}else{
					$function();
				}
			}
		}
		
		/**
		* Interpreta a comunicação PUT e chama o controller se houver 
		* @acess public
		*/
		public static function put($endpoint, $function){
			if(self::request() == self::$uri.$endpoint){
				if(is_array($function)){
					if(array_key_exists("uses", $function)){
						$uses = explode("@", $function['uses']);
						
						$Post = file_get_contents("php://input");
						$params = json_decode($Post);

						$kep = new \kep();
						$kep->getController($uses[0], $uses[1], $params);
					}
				}else{
					$function();
				}
			}
		}
		
		/**
		* Interpreta a comunicação DELETE e chama o controller se houver 
		* @acess public
		*/
		public static function delete($endpoint, $function){
			if(self::request() == self::$uri.$endpoint){
				if(is_array($function)){
					if(array_key_exists("uses", $function)){
						$uses = explode("@", $function['uses']);
						
						$Post = file_get_contents("php://input");
						$params = json_decode($Post);

						$kep = new \kep();
						$kep->getController($uses[0], $uses[1], $params);
					}
				}else{
					$function();
				}
			}
		}
		
	}