<?php
	
	namespace database;
	
	class DB extends \config\config{
		
		public static function db(){
			$json = parent::connections();

			$conn = new \mysqli($json['connections']['mysql']['host'], $json['connections']['mysql']['username'], $json['connections']['mysql']['password'], $json['connections']['mysql']['database']);
			if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
			return $conn;
		}
		
		public static function select($Query, $parameters, $Order = null){
			if(strpos($Query, "?")){
				$array  = explode('?', $Query);
				$array = array_filter($array);
				$count = count($parameters);
				$n = 0;
				foreach($array as $add){
					if(is_numeric($parameters[$n])){
						$array2[] = $add.$parameters[$n];
					}else{
						$array2[] = $add."'".$parameters[$n]."'";
					}

					$n++;
				}
				
				if($Order !== null){
					$array2[] = " ".$Order;
				}
				
				$string = implode($array2, "");
			}

			$start = self::db();
			
			$static = $start->query("$string");
			$result1 = $static->num_rows;
			
			$result = array();
			
			while($fetch = $static->fetch_array(MYSQLI_ASSOC)){
				$result[] = $fetch;
			}
	
			$array = array(
				"num_rows" => $result1,
				"fetch_array" => $result
			);
	
			return $array;
		}
		
		public static function update($Query, $parameters){
			if(strpos($Query, "?")){
				$array  = explode('?', $Query);
				$array = array_filter($array);
				$n = 0;
				foreach($array as $add){
					if(is_numeric($parameters[$n])){
						$array2[] = $add.$parameters[$n];
					}else{
						$array2[] = $add."'".$parameters[$n]."'";
					}
					$n++;
				}
				
				$string = implode($array2, "");
			}
			
			$start = self::db();
			
			$static = $start->query($string);
			$result = $start->affected_rows;
			
			return ['affected' => $result];
		}
		
		public static function insert($Query, $parameters){
			if(strpos($Query, "?")){
				$array  = explode('?', $Query);
				$array = array_filter($array);
				$n = 0;
				foreach($array as $add){
					if ($add == end($array)) { 
    					$array2[] = $add;
  					}else{
						if(is_numeric($parameters[$n])){
							$array2[] = $add.$parameters[$n];
						}else{
							$array2[] = $add."'".$parameters[$n]."'";
						}
					}
					$n++;
				}
				
				$string = implode($array2, "");
			}
			
			$start = self::db();
			
			$static = $start->query($string);
			$result = $start->affected_rows;
			$result2 = $start->insert_id;
			
			return [
				'affected' => $result,
				'insert_id' => $result2
			];
		}
		
		public static function delete($Query, $parameters){
			if(strpos($Query, "?")){
				$array  = explode('?', $Query);
				$array = array_filter($array);
				$n = 0;
				foreach($array as $add){
					if(is_numeric($parameters[$n])){
						$array2[] = $add.$parameters[$n];
					}else{
						$array2[] = $add."'".$parameters[$n]."'";
					}
					$n++;
				}
				
				$string = implode($array2, "");
			}
			
			$start = self::db();
			
			$static = $start->query($string);
			$result = $start->affected_rows;
			
			return ['affected' => $result];
		}
		
		public static function isAuth(){
			$config = parent::connections();
			
			$Active = $config['authentication']['mysqli']['activate'];

			return $Active;
		}

		public static function authentication(){
			$config = parent::connections();
			
			$Column = $config['authentication']['mysqli']['column'];
			$Database = $config['connections']['mysql']['database'];
			$Table = $config['authentication']['mysqli']['table'];
			
			$result = self::select('SELECT '.$Column.' FROM '.$Database.'.'.$Table.' WHERE '.$Column.'= ?', [$_SESSION["token"]]);
			
			$Date = $result['fetch_array'][0][$Column];
			
			return $Date;
		}
		
	}