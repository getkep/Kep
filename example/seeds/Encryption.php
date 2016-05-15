<?php

    class Encryption
    {
        public function sha512($message)
        {
            return hash('sha512', $message);
        }
    }
