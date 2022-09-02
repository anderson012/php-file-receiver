<?php
    namespace Routers;
    // imports
    // controllers
    include_once("../../controllers/response.controller.php");
    include_once("../../controllers/auth.controller.php");
    // services
    include_once("../../services/receiver.service.php");
    include_once("../../services/auth.service.php");
    // decorators
    include_once("../../decorators/decorator.php");
    include_once("../../decorators/auth.decorator.php");
    include_once("../../decorators/bypass-auth.decorator.php");
    // factories
    include_once("../../factories/bypass-auth.factory.php");
    // utils
    include_once("../../utils/constants.php");
    include_once("../../utils/read-ini.util.php");
    include_once("../../utils/validate-method-access.util.php");
    include_once("../../utils/generate-url.util.php");

    use Controllers\Auth;
    use Controllers\HttpResponse;
    use Exception;
    use Utils\ResponseStatus;

    use function Factories\makeByPassAuthService;
    use function Utils\generateUrl;
    use function Utils\validateMethodAccess;

    $auth = new Auth(makeByPassAuthService());
    $response = new HttpResponse();

    if (!validateMethodAccess()) {
        $response->makeResponse("Método não permitido", ResponseStatus::METHOD_NOT_ALLOWED);
        return;
    }

    if (!$auth->validate()) {
        $response->makeResponse("Usuário e/ou senha inválidos!", ResponseStatus::UNAUTHORIZED);
        return;
    }

    $targetFile = $_POST['targetFile'];
    $chunks = $_POST['chunks'];
    $chunksUploaded = 0;

    for ( $i = 0; $i < $chunks; $i++ ) {
        $filename = $targetFile . "-part$i";
        if ( file_exists( $filename ) ) {
            ++$chunksUploaded;
        }
    }

    if ($chunksUploaded === intval($chunks)) {
        try {
            for ($i = 0; $i < $chunks; $i++) {
                $filename = $targetFile . "-part$i";
                $file = fopen($filename, 'rb');
                $buff = fread($file, filesize($filename));
                fclose($file);

                $final = fopen($targetFile, 'ab');
                $write = fwrite($final, $buff);
                fclose($final);
                unlink($filename);
            }
            $url = generateUrl($targetFile);
            if ($url != null) {
                $url = "<b>$url</b>";
            }
            $response->makeResponse("Arquivo criado em <b>$targetFile</b>", ResponseStatus::OK, $url);
        } catch(Exception $e) {
            $response->makeResponse("Falha ao juntar partes do arquivo $e->$message", ResponseStatus::INTERNAL_SERVER_ERROR, array("chunks"=>$chunks, "found"=>$chunksUploaded));
        }
    } else {
        $response->makeResponse("Algumas partes não foram encontradas", ResponseStatus::INTERNAL_SERVER_ERROR, array("chunks"=>$chunks, "found"=>$chunksUploaded));
    }
?>