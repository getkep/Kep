<?php
	namespace KepPHP\Kep\controller;
	
	use KepPHP\Kep\config\config;

	class BaseController{
		
		/**
		* Converte uma array em JSON
		* @acess public
		* @param array $array conteúdo para retorna 
		* @return string Mensagem em JSON
		*/
		public function response($array){
			$json = json_encode($array);
			echo $json;
		}
		
		/**
		 * Seleciona o diretório
		 * @acess private
		 * @return string Diretório
		*/
		private function setDirectory(){
			$directory = config::getConfig();
			$directory = $directory['directory'];
			return $directory;
		}

		/**
		 * Verifica e carrega class
		 * @acess private
		 * @param string $Path
		 * @param string $Class
		*/
		private function loadClass($Path, $Class){
			if(file_exists($Path)){
				require_once($Path);
				if(class_exists($Class)){
					return new $Class();
				}
				return;
			}
		}

		/**
		* Carregamento de códigos reutilizáveis(Seeds)
		* @acess public
		* @param string $Seed nome do arquivo
		*/
		public function seeds($Seed = false){
			$Path = "../".$this->setDirectory().'/seeds/'.$Seed.'.php';

			$this->loadClass($Path, $Seed);
		}

		/**
		* Carregamento do model
		* @acess public
		* @param string $Model nome do arquivo
		*/
		public function model($Model = false){
			$Path = "../".$this->setDirectory().'/models/'.$Model.'.php';
			
			$this->loadClass($Path, $Model);
		}
		
	}