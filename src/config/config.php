<?php
	namespace KepPHP\Kep\config;
	
	class config{
		
		/**
		* Load configuration information
		* @acess public
		* @return array Configuration information
		*/
		public static function getConfig(){
			self::loadConfig('../config.php');

			return;
		}

		/**
		* Loads the returned file
		* @acess private
		* @return array Configuration information
		*/
		private static function loadConfig($Path){
			if(file_exists($Path)){
				require_once($Path);

				return;
			}
		}
		
	}