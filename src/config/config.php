<?php

namespace KepPHP\Kep\config;

class config
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
        $Config = $this->loadConfig('../config.php', 'configuration');
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
    private function loadConfig($Path, $Class)
    {
        if (file_exists($Path)) {
            require_once $Path;
            if (class_exists($Class)) {
                return new $Class();
            }

            return;
        }

        return;
    }
}
