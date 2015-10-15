<?php
	
	use controller\BaseController;
	
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
			$name = $this->params->name;
			
			$result = $this->load->testing($name);
			
			if($result['num_rows'] == 1){
				$Result = "sucess";
				$Message = "Sucess when sending";
				$Sha = $this->seed->sha512($Message);
			}else{
				$Result = "error";
				$Message = "An unexpected error occurred";
				$Sha = $this->seed->sha512($Message);
			}
			
			$array = array(
				"result" => $Result,
				"message" => $Message,
				"sha512" => $Sha
			);
			
			$this->response($array);
		}
		
	}