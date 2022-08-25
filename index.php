<?php
    namespace Main;
    // imports
    include_once("./controllers/receiver.controller.php");
    include_once("./controllers/response.controller.php");
    include_once("./controllers/auth.controller.php");
    //
    include_once("./services/receiver.service.php");
    //
    include_once("./utils/constants.php");
    //

    use Controllers\Auth;
    use Controllers\HttpResponse;
    use Controllers\ReceiverController;
    use Utils\ResponseStatus;
    
    $controller = new ReceiverController();
    $response = new HttpResponse();
    $auth = new Auth();

    if (!$controller->validateMethodAccess()) {
        $response->makeResponse("", ResponseStatus::METHOD_NOT_ALLOWED, "Metodo não permitido");
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
        $response->makeResponse($targetFilename, ResponseStatus::OK, "Arquivo criado com sucesso em $targetFilename");
        return;
    }
?>