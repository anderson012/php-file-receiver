<?php
    namespace Factories;

    use Decorator\LdapAuthDecorator;
    use Service\AuthService;

    function makeLdapAuthService(): AuthService {
        return new AuthService(new LdapAuthDecorator());
    }
?>