<?php
    namespace Decorator;

    use Decorator\AuthDecorator;

    class ByPassAuthDecorator implements AuthDecorator {

        public function auth(string $user, string $pass): bool
        {
            if (isset($user) && !empty($user) && isset($pass) && !empty($pass)) {
                return in_array($user, array("odm", "wsreport")) && "" === $pass;
            }

            return false;
        }
    }
