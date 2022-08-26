<?php
    namespace Factories;

    use Decorator\MysqlAuthDecorator;
    use Service\AuthService;

    function makeMysqlAuthService(): AuthService {
        return new AuthService(new MysqlAuthDecorator());
    }
?>