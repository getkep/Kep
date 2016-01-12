<?php

namespace KepPHP\Kep\route;

class Group
{
    /**
     * @acess private
     *
     * @var string
     */
    public $uri;

    /**
     * Responsible to record the group name.
     *
     * @param string $prefix
     * @acess public
     */
    public function prefix($prefix)
    {
        if (empty($prefix)) {
            $this->uri = '/'.parent::request();
        } else {
            $this->uri = '/'.$prefix.'/';
        }
    }

    /**
     * Create group.
     *
     * @param string $prefix
     * @param $function
     * @acess public
     */
    public function group($prefix, $function)
    {
        $this->prefix($prefix);
        $function();
    }
}
