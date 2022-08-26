<?php

    namespace Decorator;
    interface AuthDecorator {
        public function auth(string $user, string $pass): bool;
    }

?>