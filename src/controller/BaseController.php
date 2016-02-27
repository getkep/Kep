<?php

namespace KepPHP\Kep\controller;

use KepPHP\Kep\config\config;

class BaseController extends config
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
        $directory = $this->getConfig();

        return $directory['directory'];
    }

    /**
     * Loading reusable code (Seeds).
     *
     * @acess public
     *
     * @param string $Seed File name
     */
    public function seeds($Seed = false, $Folder = false)
    {
        return $this->loadClass($this->checkFolder($Folder, $Seed, 'seeds'), $Seed);
    }

    /**
     * Model loading.
     *
     * @acess public
     *
     * @param string $Model File name
     */
    public function model($Model = false, $Folder = false)
    {
        return $this->loadClass($this->checkFolder($Folder, $Model, 'models'), $Model);
    }

    /**
     * Checks if the folder is valid.
     *
     * @acess private
     *
     * @param string $Folder
     * @param string $File
     * @param string $Method
     */
    private function checkFolder($Folder, $File, $Method)
    {
        if ($Folder == false) {
            return "../{$this->setDirectory()}/{$Method}/{$File}.php";
        } else {
            return "../{$this->setDirectory()}/{$Method}/{$Folder}/{$File}.php";
        }
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
