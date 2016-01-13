<?php

namespace KepPHP\Kep\controller;

use KepPHP\Kep\config\config;

class BaseController
{
    /**
     * Convert an array in JSON.
     *
     * @acess public
     *
     * @param array $array Content to return
     *
     * @return string Message JSON
     */
    public function response($array)
    {
        echo json_encode($array);
    }

    /**
     * Select the directory.
     *
     * @acess private
     *
     * @return string Directory
     */
    private function setDirectory()
    {
        $directory = config::getConfig();
        $directory = $directory['directory'];

        return $directory;
    }

    /**
     * Loading reusable code (Seeds).
     *
     * @acess public
     *
     * @param string $Seed File name
     */
    public function seeds($Seed = false)
    {
        $this->loadClass('../'.$this->setDirectory().'/seeds/'.$Seed.'.php', $Seed);
    }

    /**
     * Model loading.
     *
     * @acess public
     *
     * @param string $Model File name
     */
    public function model($Model = false)
    {
        $this->loadClass('../'.$this->setDirectory().'/models/'.$Model.'.php', $Model);
    }

    /**
     * Checks and loads class.
     *
     * @acess private
     *
     * @param string $Path
     * @param string $Class
     */
    private function loadClass($Path, $Class)
    {
        if (file_exists($Path)) {
            require_once $Path;
            if (class_exists($Class)) {
                return new $Class();
            }

            return;
        }
    }
}
