<?php

namespace GetKep\Kep\authentication;

use GetKep\Kep\database\DB;

class auth extends DB
{
    /**
         * Check user session integrity.
         *
         * @acess public
         *
         * @param string $user  Username
         * @param string $token Access token
         */
        public function checkToken($user, $token)
        {
            if (!isset($_SESSION)) {
                session_start();
            }

            if (parent::isAuth() == true) {
                if (isset($_SESSION['uid'])) {
                    // Layer 1 - sent token check and compare the session
                    if ($_SESSION['token'] == $token) {
                        // Layer 2 - Check the database
                        $result = parent::authentication();

                        if ($result == $_SESSION['token']) {
                            // Successful authentication
                            return $auth['result'] = 'true';
                        } else {
                            return $auth['result'] = 'false';
                            // Returns error
                        }
                    } else {
                        return $auth['result'] = 'false';
                        // returns error
                    }
                } else {
                    return $auth['result'] = 'false';
                    // Returns error, because there is no session
                }
            } else {
                return $auth['result'] = 'disabled';
            }
        }
}
