<?php
    namespace Utils;

    function generateUrl(string $path): ?string {
        // Here you can config how url wil be generated
        $path = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $path);
        if (preg_match(Files::DBS, $path) === 1) {
            $path = explode(DIRECTORY_SEPARATOR, $path);
            $filtered = array_filter($path, function($item) {
                return strpos($item, ".com") != false;
            });
            var_dump($path);
            return $filtered[0]."/".$path[sizeof($path) - 1];
        }
        return null;
    }
?>