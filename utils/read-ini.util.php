<?php
    namespace Utils;

    function readIni() {
        return parse_ini_file("config.ini", TRUE);
    }
?>