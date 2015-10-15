<?php
	namespace controller;
	
	use \database\DB;

	class BaseController extends \database\DB{

		/**
		* Carregamento de códigos reutilizáveis(Seeds)
		* @acess public
		* @param string $Seed nome do arquivo
		*/
		public function seeds($Seed = false){
			$directory = \config\config::connections();
			$directory = $directory['directory'];
			$Seeds = '../../../../'.$directory.'/seeds/'.$Seed.'.php';
			
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
		* @acess public
		* @param array $array conteúdo para retorna 
		* @return string Mensagem em JSON
		*/
		public function response($array){
			$json = json_encode($array);
			echo $json;
		}
		
		/**
		* Carregamento do model
		* @acess public
		* @param string $Model nome do arquivo
		*/
		public function LoadModel($Model = false){
			if (!$Model) return;
			$directory = \config\config::connections();
			$directory = $directory['directory'];
			$ModelPath = '../../../../'.$directory.'/models/'.$Model.'.php';
			
			if (file_exists($ModelPath)){
				require_once($ModelPath);
				if(class_exists($Model)){
					return new $Model($this->DB());
				}
				return;
			}
		
		}
		
	}