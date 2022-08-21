<?php 

    namespace App\Model;

    /*
        Database class for MySql PDO connection
    */
    class Database {
        private $host = "localhost";
        private $database_name = "arklink";
        private $username = "root";
        private $password = "";
        public $conn;
        public function getConnection(){
            $this->conn = null;
            try{
                $options = [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $this->conn = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password, $options);
                $this->conn->exec("set names utf8");
            }catch(\PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
    }


    /*
        Database class for PostgreSql PDO connection
    */
    // class Database {
    //     private $username = "fxhswofv";
    //     private $password = "EhKSJMXQNR3aIAzMPnBfuZxYxPqaxP7C";
    //     public $conn;
    //     /**
    //      * Connect to the database and return an instance of \PDO object
    //      * @return \PDO
    //      * @throws \Exception
    //      */
    //     public function getConnection(){
    //         $this->conn = null;
    //         try{
    //             $connStr = "postgres://fxhswofv:EhKSJMXQNR3aIAzMPnBfuZxYxPqaxP7C@heffalump.db.elephantsql.com/fxhswofv";
    //             $options = [
    //                 \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    //                 \PDO::ATTR_EMULATE_PREPARES => false,
    //             ];
    //             $this->conn = new \PDO($connStr, $this->username, $this->password, $options);
    //             $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    //             $this->conn->exec("set names utf8");
    //         }catch(\PDOException $exception){
    //             echo "Database could not be connected: " . $exception->getMessage();
    //         }
    //         return $this->conn;
    //     }
    // }

    // $db = new Database();
    // $dbconn = $db->getConnection();
    // echo (string) $dbconn;
?>