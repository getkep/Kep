<?php

namespace KepPHP\Kep\database;

class Grammar
{
    /**
     * Wrap syntax of the select.
     * 
     * @acess public
     */
    public function wrapSelect($Query, $parameters, $Order = null)
    {
        if (strpos($Query, '?')) {
            $array = explode('?', $Query);
            $array = array_filter($array);
            $count = count($parameters);
            $n = 0;
            foreach ($array as $add) {
                if (is_numeric($parameters[$n])) {
                    $array2[] = $add.$parameters[$n];
                } else {
                    $array2[] = $add."'".$parameters[$n]."'";
                }

                $n++;
            }

            if ($Order !== null) {
                $array2[] = ' '.$Order;
            }

            $string = implode($array2, '');

            return $string;
        }

        return;
    }

    /**
     * Wrap syntax of the update.
     * 
     * @acess public
     */
    public function wrapUpdate($Query, $parameters)
    {
        if (strpos($Query, '?')) {
            $array = explode('?', $Query);
            $array = array_filter($array);
            $n = 0;
            foreach ($array as $add) {
                if (is_numeric($parameters[$n])) {
                    $array2[] = $add.$parameters[$n];
                } else {
                    $array2[] = $add."'".$parameters[$n]."'";
                }
                $n++;
            }

            $string = implode($array2, '');

            return $string;
        }

        return;
    }

    /**
     * Wrap syntax of the insert.
     * 
     * @acess public
     */
    public function wrapInsert($Query, $parameters)
    {
        if (strpos($Query, '?')) {
            $array = explode('?', $Query);
            $array = array_filter($array);
            $n = 0;
            foreach ($array as $add) {
                if ($add == end($array)) {
                    $array2[] = $add;
                } else {
                    if (is_numeric($parameters[$n])) {
                        $array2[] = $add.$parameters[$n];
                    } else {
                        $array2[] = $add."'".$parameters[$n]."'";
                    }
                }
                $n++;
            }

            $string = implode($array2, '');

            return $string;
        }

        return;
    }

    /**
     * Wrap syntax of the delete.
     * 
     * @acess public
     */
    public function wrapDelete($Query, $parameters)
    {
        if (strpos($Query, '?')) {
            $array = explode('?', $Query);
            $array = array_filter($array);
            $n = 0;
            foreach ($array as $add) {
                if (is_numeric($parameters[$n])) {
                    $array2[] = $add.$parameters[$n];
                } else {
                    $array2[] = $add."'".$parameters[$n]."'";
                }
                $n++;
            }

            $string = implode($array2, '');

            return $string;
        }

        return;
    }
}
