<?php
    namespace Decorator;

    use Decorator\AuthDecorator;
    use PDO;
    use Exception;
use PDOException;

    use function Utils\makeDsnFromIni;

    class MysqlAuthDecorator extends PDO implements AuthDecorator {
        private ?PDO $connection = null;

        public function __construct($file = 'config.ini')
        {
            if (!$settings = parse_ini_file($file, TRUE)) {
                throw new Exception('Unable to open ' . $file . '.');
            }

            $dns = makeDsnFromIni($settings);
            try {
                $this->connection = new PDO($dns, $settings['database']['username'], $settings['database']['password']);
            } catch (PDOException $ex) {
                //silently
                throw new Exception("Falha ao conectar no banco de dados");
            }
        }

        public function auth(string $user, string $pass): bool
        {
            try {
                $statement = $this->connection->prepare("select 1 from auth where auth_username = ? and auth_password = ?");
                $statement->execute(array($user, md5($pass)));
                $resp = $statement->fetchAll(PDO::FETCH_ASSOC);
                $statement = null;
                return (count($resp) > 0);
            } catch(Exception $ex) {
                return false;
            } finally {
                $this->connection = null;
            }
        }
    }
