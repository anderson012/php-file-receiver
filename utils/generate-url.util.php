<?php
    namespace Utils;

    function generateUrl(string $path): ?string {
        // Here you can config how url wil be generated
        
        $path = str_replace(array("/", "\\"), DIRECTORY_SEPARATOR, $path);
        $originalPath = $path;
        // if (preg_match(Files::DBS, $path) === 1) {
        $path = explode(DIRECTORY_SEPARATOR, $path);
        // print_r($path);
        $filtered = array_values(array_filter($path, function($item) {
            // echo(" |$item| ");
            return strpos($item, ".com") != false;
        }));
        if (sizeof($filtered) > 0) {
            $domain = $filtered[0];
            $filePath = explode($domain, $originalPath)[1];
            $filePath = str_replace("\\", "/", $filePath);
            return "https://".$domain.$filePath;
        }
        // }
        return null;
    }
?>