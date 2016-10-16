<?php

    use Kep\Controller\BaseController;

    class MyController extends BaseController
    {
        private $load;
        private $params;
        private $seed;

        public function __construct($parameters)
        {
            $this->load = $this->LoadModel('myModel');
            $this->seed = $this->seeds('Encryption');
            $this->params = $parameters;
        }

        public function testing()
        {
            $Result = 'sucess';
            $Message = 'Sucess when sending';
            $Sha = $this->seed->sha512($Message);

            $array = [
                'result'  => $Result,
                'message' => $Message,
                'sha512'  => $Sha,
            ];

            $this->response($array);
        }

        public function get()
        {
            $array = [
                'message' => 'Sucess when sending',
            ];

            $this->response($array);
        }

        public function put()
        {
            $array = [
                'message' => 'Sucess when sending',
            ];

            $this->response($array);
        }

        public function delete()
        {
            $array = [
                'message' => 'Sucess when sending',
            ];

            $this->response($array);
        }
    }
