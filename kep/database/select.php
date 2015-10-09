<?php
	
	namespace database;
	
	class select extends DB{
		
		private $table;
		private $selects;
		private $parameters;
		private $result;
		
		private $create;
		
		private $conn;
		
		public function select($table, $selects = "*", array $parameters = null){
			$this->table = (string) $table;
			$this->selects = (string) $selects;
			$this->parameters = $parameters;
			
			$this->syntax();
			$this->connect();
			//$this->execute();
		}
		
		private function connect(){
			$this->conn = parent::db();
			$Fileds = "'" . implode("', '", array_values($this->parameters)). "'";
			$this->create = $this->conn->prepare($this->create);
			$this->create->bind_param('s', $Fileds);
		}
		
		private function syntax(){
			if(empty($this->parameters)){
				$this->create = "SELECT {$this->selects} FROM {$this->table}";
			}else{
				$Fileds = implode(' = ?, ', array_keys($this->parameters)) . ' = ?';
				$this->create = "SELECT {$this->selects} FROM {$this->table} WHERE {$Fileds}";
			}
		}
		
		private function execute(){
			$this->connect();
			try{
				$this->create->execute();
				$this->result = $this->create->get_result();
			}catch(mysqli_sql_exception $e){
				$this->result = null;
				echo "<a>Erro ao efetuar o select</a>";
			}
		}
		
	}