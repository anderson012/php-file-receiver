<?php
    namespace Controllers;

    use Service\AuthService;

    class Auth {
        private AuthService $service;
        function __construct(AuthService $service)
        {
            $this->service = $service;
        }
        public function validate() {

            if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"])) {
                return false;
            }

            $user = $_SERVER["PHP_AUTH_USER"];
            $pass = $_SERVER["PHP_AUTH_PW"];
            

            if (empty($user) || empty($pass)) {
                return false;
            }

            return $this->service->authenticate($user, $pass);
        }
    }
?>