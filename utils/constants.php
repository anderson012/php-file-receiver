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
        const WS_REPORT = __DIR__ . "/../upload/ws";
        const EDUCATION = __DIR__ . "/../upload/edu";
        const DBS = __DIR__ . "/../upload/db";
    }

    class Files {
        const WS_REPORT = "/WsReport-1.2.dll/i";
        const EDUCATION = "/.OmegaSistemas/";
        const DBS = "/.zip|.dat|.rar|.dmp|.bak/i";
    }

    class General {
        const LDAP_SERVER = "ldap://localhost";
        const VERSION = "v0.0.1";
    }
?>