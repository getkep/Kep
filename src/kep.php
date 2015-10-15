<?php
	namespace KepPHP\Kep;
	
	/**
  	* @name Kep Micro Framework
  	* @author Matuzalém Teles <matuzalemteles@gmail.com>
	* @version 0.1 
	* @link http://kepphp.github.io website oficial do Kep Framework for PHP
	* @copyright 2015 Kep Framework
  	*/
	
	// ============================================================================ //
 	// Class
	// ============================================================================ //
	
	class Kep{
		
		/**
		* @acess private
		* @var string $controller			Recebe o nome do controller
		*/
		private $controller;
		
		/**
		* @acess private
		* @var string $action				Recebe a function para iniciar
		*/
		private $action;
		
		/**
		* @acess private
		* @var array or json $parameters 	Parametros para serem passados
		*/
		private $parameters;

		/**
		* @acess private
		* @var string $auth 				Retorna false ou true
		*/
		private $auth;
		
		/**
		* Monta o controller para efetuar as ações a pedido da route
		* @acess public
		* @return action retorna a função chamada pela route 
		*/
		public function	createController(){
			
			$directory = KepPHP\Kep\config\config::connections();
			$directory = $directory['directory'];
			
			if(!$this->controller){
				$this->responseJson("Controlador não existe.".$this->controller, 404);
				
				return;
			}
			
			if(!file_exists(__DIR__.$directory.'/controllers/'.$this->controller.'.php')){
				$this->responseJson("Não encontramos o controlador", 404);

				return;
			}
			
			require_once __DIR__.$directory.'/controllers/'.$this->controller.'.php';
			
			if(!class_exists($this->controller)){
				$this->responseJson("Não encontramos a classe do controlador", 404);
				
				return;
			}
			
			$this->controller = new $this->controller($this->parameters);
			
			if(method_exists($this->controller, $this->action)){
				$this->controller->{$this->action}($this->parameters);

				return;
			}
			
			if(!$this->action && method_exists($this->controlador, 'index' )){
				$this->controller->index($this->parameters);
				
				return;
			}
			
			$this->responseJson("Não encontramos o controller", 404);
			
			return;
		}
		
		
		/**
		* função para retorna uma mensagem em json
		* @acess private
		* @param string $Message mensagem de erro
		* @param int $Code codigo do erro
		* @return string Mensagem do erro em JSON
		*/
		private function responseJson($Message, $Code){
			$array = array(
				"status" => 'error',
				"message" => $Message,
				"code" => $Code
			);

			echo json_encode($array);
		}
		
		/**
		* verifica se existe a autenticação do usuário
		* @acess public
		* @param string $Name Nome do usuário
		* @param string $Token Token para autenticação
		* @return int retorna true ou false
		*/
		public function isAuth($Name, $Token){
			$auth = new authentication\auth();

			$check = $auth->checkToken($Name, $Token);

			if($check == "disabled"){
				return true;
			}elseif($check == "true"){
				return true;
			}elseif($check == "false"){
				return false;
			}
		}
		
		/**
		* Função run, chama a função createController()
		* @acess public
		* @param string $controller
		* @param string $action
		* @param array||json $params
		*/
		public function getController($controller, $action, $params){
			$this->controller = $controller;
			$this->action = $action;
			$this->parameters = $params;

			if(isset($params->user) && isset($params->token)){
				if($this->isAuth($params->user, $params->token) == true){
					$this->createController();
				}else{
					$this->responseJson("Falha na autenticação", 404);
				}
			}else{
				$this->createController();
			}
		}
		
	}