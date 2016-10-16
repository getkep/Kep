<?php

namespace Kep\Controller;

use Kep\Config\Config;

class BaseController extends Config
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
     * @param string $seed File name
     */
    public function seeds($seed = null, $folder = null)
    {
        return $this->loadClass($this->checkFolder($folder, $seed, 'seeds'), $seed);
    }

    /**
     * Model loading.
     *
     * @acess public
     *
     * @param string $model File name
     */
    public function model($model = null, $folder = null)
    {
        return $this->loadClass($this->checkFolder($folder, $model, 'models'), $model);
    }

    /**
     * Checks if the folder is valid.
     *
     * @acess private
     *
     * @param string $folder
     * @param string $file
     * @param string $method
     */
    private function checkFolder($folder, $file, $method)
    {
        if ($folder == null) {
            return "../{$this->setDirectory()}/{$method}/{$file}.php";
        } else {
            return "../{$this->setDirectory()}/{$method}/{$folder}/{$file}.php";
        }
    }

    /**
     * Checks and loads class.
     *
     * @acess private
     *
     * @param string $path
     * @param string $class
     */
    private function loadClass($path, $class)
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
