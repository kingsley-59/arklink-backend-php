<?php 

    namespace App\Model;
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
?>