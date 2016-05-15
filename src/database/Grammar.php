<?php

namespace GetKep\Kep\Database;

class Grammar
{
    /**
     * Wrap syntax of the select.
     *
     * @acess public
     */
    public function wrapSelect($query, $parameters, $order = null)
    {
        if (strpos($query, '?')) {
            $array = explode('?', $query);
            $array = array_filter($array);
            $count = count($parameters);
            $cont = 0;
            foreach ($array as $add) {
                if (is_numeric($parameters[$cont])) {
                    $array2[] = $add.$parameters[$cont];
                } else {
                    $array2[] = $add."'".$parameters[$cont]."'";
                }

                $cont++;
            }

            if ($order !== null) {
                $array2[] = ' '.$order;
            }

            $string = implode($array2, '');

            return $string;
        }
    }

    /**
     * Wrap syntax of the update.
     *
     * @acess public
     */
    public function wrapUpdate($query, $parameters)
    {
        if (strpos($query, '?')) {
            $array = explode('?', $query);
            $array = array_filter($array);
            $cont = 0;
            foreach ($array as $add) {
                if (is_numeric($parameters[$cont])) {
                    $array2[] = $add.$parameters[$cont];
                } else {
                    $array2[] = $add."'".$parameters[$cont]."'";
                }
                $cont++;
            }

            $string = implode($array2, '');

            return $string;
        }
    }

    /**
     * Wrap syntax of the insert.
     *
     * @acess public
     */
    public function wrapInsert($query, $parameters)
    {
        if (strpos($query, '?')) {
            $array = explode('?', $query);
            $array = array_filter($array);
            $cont = 0;
            foreach ($array as $add) {
                if ($add == end($array)) {
                    $array2[] = $add;
                } else {
                    if (is_numeric($parameters[$cont])) {
                        $array2[] = $add.$parameters[$cont];
                    } else {
                        $array2[] = $add."'".$parameters[$cont]."'";
                    }
                }
                $cont++;
            }

            $string = implode($array2, '');

            return $string;
        }
    }

    /**
     * Wrap syntax of the delete.
     *
     * @acess public
     */
    public function wrapDelete($query, $parameters)
    {
        if (strpos($query, '?')) {
            $array = explode('?', $query);
            $array = array_filter($array);
            $cont = 0;
            foreach ($array as $add) {
                if (is_numeric($parameters[$cont])) {
                    $array2[] = $add.$parameters[$cont];
                } else {
                    $array2[] = $add."'".$parameters[$cont]."'";
                }
                $cont++;
            }

            $string = implode($array2, '');

            return $string;
        }
    }
}
