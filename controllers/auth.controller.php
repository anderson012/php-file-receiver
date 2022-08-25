<?php
    namespace Controllers;

    class Auth {
        public function validate() {
            
            
            if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"])) {
                return false;
            }
            $user = $_SERVER["PHP_AUTH_USER"];
            $pass = $_SERVER["PHP_AUTH_PW"];
            echo "'$user'";
            if (is_null($user) || is_null($pass)) {
                return false;
            }
        }
    }
?>