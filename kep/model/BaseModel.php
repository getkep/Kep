<?php
	
	namespace model;
	
	class BaseModel{
		
		public $controller;
		
		public $db;
		
		public static function Transitions($Transitions, $Tick, $function){
			if($Transitions == $Tick){
				$function();
			}
		}
		
	}