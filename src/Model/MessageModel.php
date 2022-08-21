<?php 
namespace App\Model;

//require __DIR__.'./Database.php';

use App\Model\Database;

class Message extends Database 
{
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function createMessage(Array $input)
    {
        $query = "
            INSERT INTO contact_messages
                (name, email, message, has_seen, date_added)
            VALUES (:name, :email, :message, false, now());
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'name' => $input['name'],
                'email' => $input['email'],
                'message' => $input['message']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getAllMessages()
    {
        $query = "
            SELECT * FROM contact_messages ORDER BY id DESC;
        ";

        try {
            $statement = $this->conn->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function updateMessage($id, $values)
    {
        $query = "
            UPDATE contact_messages SET
            `has_seen` = true
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

    public function deleteMessage($id)
    {
        $query = "
            DELETE FROM contact_messages
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
