<?php
    namespace Utils;

    function validateMethodAccess(array $valid = array("POST")) {
        return in_array($_SERVER["REQUEST_METHOD"], $valid);
    }
?>