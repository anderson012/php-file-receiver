<?php
    namespace Controllers;

    use Utils\ResponseType;
    use Utils\ResponseStatus;

    class HttpResponse {
        public static function makeResponse($msg,  $code = ResponseStatus::OK, $resp = null) {
            http_response_code($code);
            header(ResponseType::JSON_TYPE);
            $resp = json_encode(array("result"=>$resp, "msg"=>$msg, "code"=>$code));
            echo($resp);
        }
    }
?>