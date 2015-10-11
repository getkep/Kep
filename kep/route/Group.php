<?php

	namespace route;
	
	class Group{
		
		/**
		* @acess private
		* @var string $uri
		*/
		public static $uri;
		
		/**
		* Responsavel em gravar o nome do grupo
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
		* criar o grupo
		* @param string $prefix
		* @param  $function
		* @acess public
		*/
		public static function group($prefix, $function){
			self::prefix($prefix);
			$function();
		}
		
	}