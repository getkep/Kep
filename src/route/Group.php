<?php

	namespace KepPHP\Kep\route;
	
	class Group{
		
		/**
		* @acess private
		* @var string $uri
		*/
		public static $uri;
		
		/**
		* Responsible to record the group name
		* @param string $prefix
		* @acess public
		*/
		public static function prefix($prefix){
			if(empty($prefix)){
				self::$uri = "/".parent::request();
			}else{
				self::$uri = "/".$prefix."/";
			}
		}
		
		/**
		* Create group
		* @param string $prefix
		* @param  $function
		* @acess public
		*/
		public static function group($prefix, $function){
			self::prefix($prefix);
			$function();
		}
		
	}