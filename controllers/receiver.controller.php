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
            if (strpos($file, Files::WS_REPORT) === true) {
                $this->targetDir = Path::WS_REPORT;
            } else if (strpos($file, Files::EDUCATION) === true) {
                $this->targetDir = Path::EDUCATION;
            }
        }

        public function setFile(): string {
            if (isset($_FILES["file"])) {
                $file = $_FILES["file"]["tmp_name"];
                $this->tmpFilename = $file;
                $this->targetFile = $_FILES["file"]["name"];
                $this->setTargetDir($this->targetFile);
            }
            
            return $this->tmpFilename;
        }

        public function validate(): bool {
            if (is_null($this->tmpFilename) || !is_uploaded_file($this->tmpFilename)) {
                return false;
            //TODO: alterar para regex
            } else if (strpos($this->targetFile, Files::WS_REPORT) === false && strpos($this->targetFile, Files::EDUCATION) === false) {
                return false;
            }
            return true;
        }

        public function fileExists() {
            return $this->service->fileExists("$this->targetDir/$this->targetFile");
        }

        public function createFile(): bool {
            return $this->service->createFile($this->tmpFilename, $this->targetFile);
        }

        public function validateMethodAccess() {
            return $_SERVER["REQUEST_METHOD"] === "POST";
        }



        //Getters and setters
        public function getTargetFile() {
            return $this->targetFile;
        }
    }
?>