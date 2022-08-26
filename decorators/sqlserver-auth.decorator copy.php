<?php
    namespace Decorator;

    use Decorator\AuthDecorator;
    class SqlServerAuthDecorator implements AuthDecorator {

        public function __construct($file = 'db.ini')
        {
            // if (!$settings = parse_ini_file($file, TRUE)) {
            //     throw new Exception('Unable to open ' . $file . '.');
            // }
            // $serverName = "serverName\\sqlexpress"; //serverName\instanceName

            // // Since UID and PWD are not specified in the $connectionInfo array,
            // // The connection will be attempted using Windows Authentication.
            // $connectionInfo = array( "Database"=>"dbName");
            // $conn = sqlsrv_connect( $serverName, $connectionInfo);

            // if( $conn ) {
            //     echo "Connection established.<br />";
            // }else{
            //     echo "Connection could not be established.<br />";
            //     die( print_r( sqlsrv_errors(), true));
            // }
        }

        public function auth(string $user, string $pass): bool
        {
            return false;
        }
    }
