<?php 
namespace App\Model;

//require __DIR__.'./Database.php';

use App\Model\Database;

class Product extends Database 
{
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function createProduct(Array $input)
    {
        $query = "
            INSERT INTO products
                (name, category, description, photo_url, date_added)
            VALUES (:name, :category, :description, :photo_url, now());
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'name' => $input['name'],
                'category' => $input['category'],
                'description' => $input['description'],
                'photo_url' => $input['photo_url']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getAllProducts()
    {
        $query = "
            SELECT * FROM products ORDER BY id DESC;
        ";

        try {
            $statement = $this->conn->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getOneProduct($id)
    {
        $query = "
            SELECT * FROM products WHERE id = ? ;
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

    public function updateProduct($id, $values)
    {
        $name = $values['name'] ?? null;
        $category = $values['category'] ?? null;
        $description = $values['description'] ?? null;
        $query = "
            UPDATE products SET
            `name` = '$name',
            `category` = '$category',
            `description` = '$description'
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

    public function deleteProduct($id)
    {
        $query = "
            DELETE FROM products
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
