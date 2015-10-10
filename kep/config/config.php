<?php
	namespace config;
	
	class config{
		
		public static function connections(){
			return  [
				'directory' => 'v1',
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