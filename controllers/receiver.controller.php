<?php 
    namespace Controllers;

    use Service\ReceiverService;
    use Utils\Files;
    use Utils\Path;

    class ReceiverController {
        private $targetDir = Path::WS_REPORT;
        private $targetFile = "";
        private $tmpFilename = "";
        private $service = null;

        function __construct() {
            $this->service = new ReceiverService();
        }

        public function setTargetDir($file) {
            $version = $_POST["version"];
            if (preg_match(Files::WS_REPORT, $file) === 1) {
                $this->targetDir = join(DIRECTORY_SEPARATOR, array(Path::WS_REPORT, "$version"));
            } else if (preg_match(Files::EDUCATION, $file) === 1) {
                $this->targetDir = join(DIRECTORY_SEPARATOR, array(Path::EDUCATION, "$version"));
            } else {
                echo "";
            }
        }

        public function setFile(): string {
            if (isset($_FILES["file"])) {
                $file = $_FILES["file"]["tmp_name"];
                $this->tmpFilename = $file;
                $this->targetFile = $_FILES["file"]["name"];
                $this->setTargetDir($this->targetFile);
                $this->service->createDir($this->targetDir);
            }

            return $this->tmpFilename;
        }

        public function validate(): bool {
            if (is_null($this->tmpFilename) || !is_uploaded_file($this->tmpFilename)) {
                return false;
            } else if (preg_match(Files::WS_REPORT, $this->targetFile) === 0 && strpos(Files::EDUCATION, $this->targetFile) === 0) {
                return false;
            }
            return true;
        }

        public function fileExists() {
            return $this->service->fileExists("$this->targetDir/$this->targetFile");
        }

        public function createFile(): bool {
            return $this->service->createFile($this->tmpFilename, "$this->targetDir/$this->targetFile");
        }
        //Getters and setters
        public function getTargetFile() {
            return $this->targetFile;
        }

        public function getTargetDir() {
            return $this->targetDir;
        }
    }
?>