<?php
	
	/**
	 * Configuration file structure.
	*/ 

	return  [
		'directory' => 'v1',
			'connections' => [
				'mysql' => [
					'driver'    => 'mysqli',
					'host'      => 'azure-data.shieldblock.com.br',
					'database'  => 'ShieldBlock',
					'username'  => 'matuzalem',
					'password'  => 'xSw10985',
				],
			],
		'authentication' => [
			'mysqli' => [
				'activate' => false,
				'table' => 'All_Usuarios',
				'column' => 'identificationKey',
			],
		],
	];