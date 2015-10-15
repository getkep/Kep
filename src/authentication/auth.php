<?php
	namespace KepPHP\Kep\authentication;
	
	use KepPHP\Kep\database\DB;

	class auth extends DB{

		public function checkToken($user, $token){
			if (!isset($_SESSION)) {
        		session_start();
    		}
			
			if(parent::isAuth() == true){
				if(isset($_SESSION['uid'])){
					// Camada 1 - Verificação da token enviada e comparar com a da session
					if($_SESSION["token"] == $token){
						// Camada 2 - Verificar no banco de dados
						$result = parent::authentication();
					
						if($result == $_SESSION["token"]){
						// Sucesso na autenticação
							return $auth['result'] = "true";
						}else{
							return $auth['result'] = "false";
							// Retorna erro
						}
					}else{
						return $auth['result'] = "false";
						// Retorna erro
					}
				}else{
					return $auth['result'] = "false";
					// Retorna erro, por que não tem nenhuma sessão
				}
			}else{
				return $auth['result'] = "disabled";
			}
		}

	}