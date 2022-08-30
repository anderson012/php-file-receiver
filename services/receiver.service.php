<?php 
    namespace Service;

    class ReceiverService {
        public function fileExists($file) {
            return file_exists($file);
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