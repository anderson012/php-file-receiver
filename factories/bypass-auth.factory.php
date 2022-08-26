<?php
    namespace Factories;

use Decorator\ByPassAuthDecorator;
    use Service\AuthService;

    function makeByPassAuthService(): AuthService {
        return new AuthService(new ByPassAuthDecorator());
    }
?>