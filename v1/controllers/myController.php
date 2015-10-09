<?php
	
	use controller\BaseController;
	
	class myController extends BaseController{
	
		private $load;
		private $parameters;
		
		function __construct($parameters){
			$this->load = $this->LoadModel('myModel');
			$this->params = $parameters;
		}
		
		public function testing(){
			$name = $this->params->name;
			
			$result = $this->load->testing($name);
			
			if($result['num_rows'] == 1){
				$Result = "sucess";
				$Message = "Sucess when sending";
			}else{
				$Result = "error";
				$Message = "An unexpected error occurred";
			}
			
			$array = array(
				"result" => $Result,
				"message" => $Message
			);
			
			$this->response($array);
		}
		
	}