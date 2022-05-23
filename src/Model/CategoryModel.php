<?php 
namespace App\Model;

//require __DIR__.'./Database.php';

use App\Model\Database;

class Category extends Database 
{
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function createCategory(Array $input)
    {
        $query = "
            INSERT INTO categories
                (name, no_of_products, date_added)
            VALUES (:name, :number, now());
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'name' => $input['name'],
                'number' => $input['count']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getAllCategory()
    {
        $query = "
            SELECT * FROM categories;
        ";

        try {
            $statement = $this->conn->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getOneCategory($id)
    {
        $query = "
            SELECT * FROM categories WHERE id = ? ;
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function UpdateCategory($id, $new_count)
    {
        $query = "
            UPDATE categories
            SET no_of_products = :number
            WHERE id = :id ;
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'id' => (int) $id,
                'number' => (int) $new_count
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function deleteCategory($id)
    {
        $query = "
            DELETE FROM categories
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
