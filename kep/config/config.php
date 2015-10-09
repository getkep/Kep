<?php
	namespace config;
	
	class config{
		
		public static function connections(){
			return  [
    			'connections' => [
        			'mysql' => [
            			'driver'    => 'mysqli',
            			'host'      => 'localhost',
            			'database'  => 'database',
            			'username'  => 'root',
            			'password'  => '',
        			],
    			],
				'authentication' => [
					'mysqli' => [
						'activate' => false,
						'table' => 'table',
						'column' => 'column',
					],
				],
			];
		}
		
	}