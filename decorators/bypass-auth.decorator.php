<?php
    namespace Decorator;

    use Decorator\AuthDecorator;
    use function Utils\readIni;

    class ByPassAuthDecorator implements AuthDecorator {

        public function auth(string $user, string $pass): bool
        {
            $config = readIni();
            $users = explode("|", $config["database"]["username"]);
            $passwords = explode("|", $config["database"]["password"]);
            $pass = md5($pass);

            if (isset($user) && !empty($user) && isset($pass) && !empty($pass)) {
                return in_array($user, $users) && in_array($pass, $passwords);
            }

            return false;
        }
    }
