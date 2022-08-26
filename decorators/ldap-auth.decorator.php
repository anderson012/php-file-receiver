<?php
    namespace Decorator;

    use Decorator\AuthDecorator;
    use Utils\General;

    class LdapAuthDecorator implements AuthDecorator {

        public function auth(string $user, string $pass): bool
        {
            $connection = ldap_connect(General::LDAP_SERVER);
            if (!$connection) {
                return false;
            }

            $bound = ldap_bind($connection, $user, $pass);
            return $bound;
        }
    }
?>