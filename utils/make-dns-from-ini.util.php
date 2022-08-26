<?php
    namespace Utils;

    function makeDsnFromIni($ini): string {
        return $ini['database']['driver'] .
        ':host=' . $ini['database']['host'] .
        ((!empty($ini['database']['port'])) ? (';port=' . $ini['database']['port']) : '') .
        ';dbname=' . $ini['database']['schema'];
    }
?>