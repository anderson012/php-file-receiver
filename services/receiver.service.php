<?php 
    namespace Service;

    class ReceiverService {
        public function fileExists($file) {
            return file_exists($file);
        }

        public function createLastVersionFile($file, $version) {
            if (file_exists($file)) {
                $oldVersion = file_get_contents($file);
                file_put_contents($file."-old", $oldVersion);
            }
            file_put_contents($file, $version);
        }

        public function createFile($tmpFile, $targetFile): bool {
            if (!$this->fileExists($targetFile)) {
                return move_uploaded_file($tmpFile, $targetFile);
            }
        }

        public function createDir($dir) {
            if (!is_dir($dir)) {
                mkdir($dir);
            }
        }
    }
?>