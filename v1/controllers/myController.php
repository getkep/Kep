<?php
	
	use KepPHP\Kep\controller\BaseController;
	
	class myController extends BaseController{
	
		private $load;
		private $parameters;
		private $seed;
		
		function __construct($parameters){
			$this->load = $this->LoadModel('myModel');
			$this->seed = $this->seeds('encryption');
			$this->params = $parameters;
		}
		
		public function testing(){
			
			$Result = "sucess";
			$Message = "Sucess when sending";
			$Sha = $this->seed->sha512($Message);
			
			$array = array(
				"result" => $Result,
				"message" => $Message,
				"sha512" => $Sha
			);
			
			$this->response($array);
			
		}
		
		public function get(){
			$array = array(
				"message" => "Sucess when sending"
			);
			
			$this->response($array);
		}
		
		public function put(){
			$array = array(
				"message" => "Sucess when sending"
			);
			
			$this->response($array);
		}
		
		public function delete(){
			$array = array(
				"message" => "Sucess when sending"
			);
			
			$this->response($array);
		}
		
	}