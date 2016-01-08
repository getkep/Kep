<?php
	namespace KepPHP\Kep\controller;
	
	use KepPHP\Kep\config\config;

	class BaseController{
		
		/**
		* Convert an array in JSON
		* @acess public
		* @param array $array Content to return
		* @return string Message JSON
		*/
		public function response($array){
			$json = json_encode($array);
			echo $json;
		}
		
		/**
		 * Select the directory
		 * @acess private
		 * @return string Directory
		*/
		private function setDirectory(){
			$directory = config::getConfig();
			$directory = $directory['directory'];
			return $directory;
		}

		/**
		 * Checks and loads class
		 * @acess private
		 * @param string $Path
		 * @param string $Class
		*/
		private function loadClass($Path, $Class){
			if(file_exists($Path)){
				require_once($Path);
				if(class_exists($Class)){
					return new $Class();
				}
				return;
			}
		}

		/**
		* Loading reusable code (Seeds)
		* @acess public
		* @param string $Seed File name
		*/
		public function seeds($Seed = false){
			$Path = "../".$this->setDirectory().'/seeds/'.$Seed.'.php';

			$this->loadClass($Path, $Seed);
		}

		/**
		* Model loading
		* @acess public
		* @param string $Model File name
		*/
		public function model($Model = false){
			$Path = "../".$this->setDirectory().'/models/'.$Model.'.php';
			
			$this->loadClass($Path, $Model);
		}
		
	}