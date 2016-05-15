<?php

namespace GetKep\Kep\Config;

class Config
{
    /**
     * Load configuration information.
     *
     * @acess public
     *
     * @return array Configuration information
     */
    public function getConfig()
    {
        $Config = self::loadConfig('../config.php', 'configuration');
        $Config = $Config->config();

        return $Config;
    }

    /**
     * Loads the returned file.
     *
     * @acess private
     *
     * @return array Configuration information
     */
    private function loadConfig($path, $class)
    {
        if (file_exists($path)) {
            require_once $path;
            if (class_exists($class)) {
                return new $class();
            }

            return;
        }
    }
}
