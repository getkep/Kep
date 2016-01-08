<?php
	namespace KepPHP\Kep;
	
	/**
  	* @name Kep Micro-Framework
  	* @author Matuzalém S. Teles <matuzalemteles@gmail.com>
	* @link http://getkep.com website oficial do Kep Framework for PHP
	* @copyright 2016 Kep Framework
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
			
			$directory = \KepPHP\Kep\config\config::getConfig();
			$directory = $directory['directory'];

			$Path = "../".$directory.'/controllers/'.$this->controller.'.php';

			$this->checkController($Path);
			
			return;
		}

		/**
		* Checar se o parâmetro controller existe ou está vazio
		* @acess private
		* @param string $Path caminho do controlador
		*/
		private function checkController($Path){
			if(!$this->controller){
				$this->responseJson("Controlador não existe.".$this->controller, 404);
				
				return;
			}

			$this->checkPatchController($Path);
		}
		
		/**
		* Checar se o caminho do controller existe
		* @acess private
		* @param string $Path caminho do controlador
		*/
		private function checkPatchController($Path){
			if(!file_exists($Path)){
				$this->responseJson("Não encontramos o controlador: ".$Path, 404);

				return;
			}

			$this->checkClassController($Path);
		}

		/**
		* Checar se a classe do controlador existe
		* @acess private
		* @param string $Path caminho do controlador
		*/
		private function checkClassController($Path){
			require_once $Path;

			if(!class_exists($this->controller)){
				$this->responseJson("Não encontramos a classe do controlador", 404);
				
				return;
			}

			$this->controller = new $this->controller($this->parameters);

			$this->checkMethodController();
		}
		
		/**
		* Checar se o método existe
		* @acess private
		*/
		private function checkMethodController(){
			if(method_exists($this->controller, $this->action)){
				$this->controller->{$this->action}($this->parameters);

				return;
			}

			$this->checkActionController();
		}

		/**
		* Checar se a função da classe chamada existe no controlador
		* @acess private
		*/
		private function checkActionController(){
			if(!$this->action && method_exists($this->controlador, 'index' )){
				$this->controller->index($this->parameters);
				
				return;
			}

			$this->responseJson("Não encontramos o controller", 404);
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