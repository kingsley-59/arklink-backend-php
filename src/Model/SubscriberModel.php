<?php 
namespace App\Model;

//require __DIR__.'./Database.php';

use App\Model\Database;

class Subscriber extends Database
{
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function createSubscriber(Array $input)
    {
        $query = "
            INSERT INTO subscribers
                (email, isVerified, date_added)
            VALUES (:email, false, now());
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array('email' => $input['email']));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getAllSubscribers()
    {
        $query = "
            SELECT * FROM subscribers ORDER BY id DESC;
        ";

        try {
            $statement = $this->conn->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function updateSubscriber($id)
    {
        $query = "
            UPDATE subscribers SET
            isVerified = true
            WHERE id = $id ;
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute();
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function deleteSubscriber($id)
    {
        $query = "
            DELETE FROM subscribers
            WHERE id = ? ;
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array($id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }
}
