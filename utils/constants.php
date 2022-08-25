<?php
    namespace Utils;
    class ResponseStatus {
        const OK = 200;
        const INTERNAL_SERVER_ERROR = 500;
        const UNAUTHORIZED = 401;
        const METHOD_NOT_ALLOWED = 405;
    }

    class ResponseType {
        const JSON_TYPE = "Content-Type: application/json";
    }

    class Path {
        const WS_REPORT = "C:\\Users\\ander\\projetos\\php-file-upload\\upload\\wsreport";
        const EDUCATION = "C:\\Users\\ander\\projetos\\php-file-upload\\upload\\educacao";
    }

    class Files {
        const WS_REPORT = "WsReport-1.2.dll";
        const EDUCATION = "Education.exe";
    }
?>