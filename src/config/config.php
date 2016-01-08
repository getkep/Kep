<?php
	namespace KepPHP\Kep\config;
	
	class config{
		
		/**
		* Carregar informações da configuração
		* @acess public
		* @return array Informações de configuração
		*/
		public static function getConfig(){
			self::loadConfig('../config.php');

			return;
		}

		/**
		* Carrega o arquivo retornado
		* @acess private
		* @return array Informações de configuração
		*/
		private static function loadConfig($Path){
			if(file_exists($Path)){
				require_once($Path);

				return;
			}
		}
		
	}