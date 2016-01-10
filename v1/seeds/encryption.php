<?php

    class encryption
    {
        public function sha512($message)
        {
            return hash('sha512', $message);
        }
    }
