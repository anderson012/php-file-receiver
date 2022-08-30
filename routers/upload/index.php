<?php
    namespace Routers;
    // imports
    // controllers
    include_once("../../controllers/receiver.controller.php");
    include_once("../../controllers/response.controller.php");
    include_once("../../controllers/auth.controller.php");
    // services
    include_once("../../services/receiver.service.php");
    include_once("../../services/auth.service.php");
    // decorators
    include_once("../../decorators/decorator.php");
    include_once("../../decorators/auth.decorator.php");
    include_once("../../decorators/ldap-auth.decorator.php");
    include_once("../../decorators/mysql-auth.decorator.php");
    include_once("../../decorators/bypass-auth.decorator.php");
    // factories
    include_once("../../factories/ldap-auth.factory.php");
    include_once("../../factories/mysql-auth.factory.php");
    include_once("../../factories/bypass-auth.factory.php");
    // utils
    include_once("../../utils/constants.php");
    include_once("../../utils/make-dns-from-ini.util.php");
    include_once("../../utils/read-ini.util.php");
    include_once("../../utils/validate-method-access.util.php");
    //
    use Controllers\Auth;
    use Controllers\HttpResponse;
    use Controllers\ReceiverController;
    use Utils\ResponseStatus;
    // use function Factories\makeLdapAuthService;
    use function Factories\makeByPassAuthService;
    use function Utils\validateMethodAccess;

    // use function Factories\makeMysqlAuthService;

    $controller = new ReceiverController();
    $response = new HttpResponse();
    $auth = new Auth(makeByPassAuthService());

    if (validateMethodAccess()) {
        $response->makeResponse("Método não permitido", ResponseStatus::METHOD_NOT_ALLOWED);
        return;
    }

    if (!$auth->validate()) {
        $response->makeResponse("Usuário e/ou senha inválidos!", ResponseStatus::UNAUTHORIZED);
        return;
    }

    $controller->setFile();

    if (!$controller->validate()) {
        $target=$controller->getTargetFile();
        $response->makeResponse("Arquivo '$target' inválido!", ResponseStatus::INTERNAL_SERVER_ERROR);
        return;
    }

    if ($controller->fileExists()) {
        $target=$controller->getTargetFile();
        $response->makeResponse("Arquivo '$target' já existe no servidor!", ResponseStatus::INTERNAL_SERVER_ERROR);
        return;
    }

    $created = $controller->createFile();

    if ($created) {
        $targetFilename = $controller->getTargetFile();
        $targetDir = $controller->getTargetDir();
        $response->makeResponse("Arquivo criado com sucesso em $targetDir/$targetFilename", ResponseStatus::OK, "$targetDir/$targetFilename");
        return;
    }
?>