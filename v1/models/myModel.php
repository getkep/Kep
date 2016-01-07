<?php
	
	use KepPHP\Kep\database\DB;
	use KepPHP\Kep\model\BaseModel;
	
	class myModel extends BaseModel{
		
		public function testing($name){
			$result = DB::select('SELECT * FROM Users WHERE Name = ?', [$name]);
			
			return $result;
		}
    
	}