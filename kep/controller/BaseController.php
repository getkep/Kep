<?php
	use \database\DB;
	namespace controller;
	
	class BaseController extends \database\DB{
		
		public $protocol;

		// Load dos seeds
		public function seeds($Model = false){
			$Seeds = '../v1/seeds/'.$Model.'.php';
			
			if(file_exists($Seeds)){
				require_once($Seeds);
				$Model = explode('/', $Model);
				$Model = end($Model);
				$Model = preg_replace( '/[^a-zA-Z0-9]/is', '', $Model);
				if(class_exists($Model)){
					return new $Model();
				}
				return;
			}
		}
		
		// Retorna array em json
		public function response($array){
			$json = json_encode($array);
			echo $json;
		}
		
		// Load do Model
		public function LoadModel($Model = false){
			if (!$Model) return;
			$ModelPath = '../v1/models/'.$Model.'.php';
			
			if (file_exists($ModelPath)){
				require_once($ModelPath);
				$Model = explode('/', $Model);
				$Model = end($Model);
				$Model = preg_replace( '/[^a-zA-Z0-9]/is', '', $Model);
				if(class_exists($Model)){
					return new $Model($this->DB());
				}
				return;
			}
		
		}
		
	}