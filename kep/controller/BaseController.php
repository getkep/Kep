<?php
	namespace controller;
	
	use \database\DB;

	class BaseController extends \database\DB{

		/**
		* Carregamento de códigos reutilizáveis(Seeds)
		* @acess private
		* @param string $Seed nome do arquivo
		*/
		private function seeds($Seed = false){
			$directory = \config\config::connections();
			$directory = $directory['directory'];
			$Seeds = '/'.$directory.'/seeds/'.$Seed.'.php';
			
			if(file_exists($Seeds)){
				require_once($Seeds);
				if(class_exists($Seed)){
					return new $Seed();
				}
				return;
			}
		}
		
		/**
		* Converte uma array em JSON
		* @acess private
		* @param array $array conteúdo para retorna 
		* @return string Mensagem em JSON
		*/
		private function response($array){
			$json = json_encode($array);
			echo $json;
		}
		
		/**
		* Carregamento do model
		* @acess private
		* @param string $Model nome do arquivo
		*/
		private function LoadModel($Model = false){
			if (!$Model) return;
			$directory = \config\config::connections();
			$directory = $directory['directory'];
			$ModelPath = '/'.$directory.'/models/'.$Model.'.php';
			
			if (file_exists($ModelPath)){
				require_once($ModelPath);
				if(class_exists($Model)){
					return new $Model($this->DB());
				}
				return;
			}
		
		}
		
	}