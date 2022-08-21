<?php 
namespace App\Model;

//require __DIR__.'./Database.php';

use App\Model\Database;

class Quote extends Database
{
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function createQuote(Array $input)
    {
        $query = "
            INSERT INTO quote_messages
                (name, email, phone, address, quote_details, has_seen, date_added)
            VALUES (:name, :email, :phone, :address, :quote_details, false, now());
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'quote_details' => $input['details']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getAllQuotes()
    {
        $query = "
            SELECT * FROM quote_messages ORDER BY id DESC;
        ";

        try {
            $statement = $this->conn->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function updateQuote($id)
    {
        $query = "
            UPDATE quote_messages SET
            has_seen = true
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

    public function deleteQuote($id)
    {
        $query = "
            DELETE FROM quote_messages
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
