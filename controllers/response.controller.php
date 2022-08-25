<?php
    namespace Controllers;

    use Utils\ResponseType;
    use \Utils\ResponseStatus;

    class HttpResponse {
        public static function makeResponse($resp, $code = ResponseStatus::OK, $msg = "") {
            http_response_code($code);
            header(ResponseType::JSON_TYPE);
            $resp = json_encode(array("result"=>$resp, "mgs"=>$msg, "code"=>$code));
            echo($resp);
        }
    }
?>