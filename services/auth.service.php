<?php
    namespace Service;

    use Decorator\AuthDecorator;

    class AuthService {
        private $decorator = null;
        function __construct(AuthDecorator $decorator) {
            $this->decorator = $decorator;
        }

        public function authenticate(string $user, string $pass): bool {
            return $this->decorator->auth($user, $pass);
        }
    }
?>