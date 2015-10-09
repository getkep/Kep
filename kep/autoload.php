<?php
	// Autoload
	// @Author : Matuzalém Teles <matuzalemteles@gmail.com>
	// @Version: 0.0.1
	
	// ============================================================================ //
    // Autoload de classes do kep framework
	// ============================================================================ //
    
	function __autoload($class){
		$dir = dirname(__FILE__);
		
        $class = $dir.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $class).".php";
        
		if(!file_exists($class)){
			echo "File path {$class} not found.";
		}else{
			require_once($class);
		}
	}
	
	// ============================================================================ //