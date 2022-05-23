<?php 
namespace App\Model;

//require __DIR__.'./Database.php';

use App\Model\Database;

class Content extends Database 
{
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function createContent(Array $input)
    {
        $query = "
            INSERT INTO site_content
                (banner_heading, banner_text, about_essay, email, phone, facebook_url, instagram_url, twitter_url, whatsapp_no, address, last_modified)
            VALUES (:banner_heading, :banner_text, :about_essay, :email, :phone, :facebook_url, :instagram_url, :twitter_url, :whatsapp_no, :address, now());
        ";

        try {
            $statement = $this->conn->prepare($query);
            $statement->execute(array(
                'banner_heading' => $input['banner_heading'],
                'banner_text' => $input['banner_text'],
                'about_essay' => $input['about_essay'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'facebook_url' => $input['facebook_url'] ?? null,
                'instagram_url' => $input['instagram_url'] ?? null,
                'twitter_url' => $input['twitter_url'] ?? null,
                'whatsapp_no' => $input['whatsapp_no'] ?? null,
                'address' => $input['address']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getAllContent()
    {
        $query = "
            SELECT * FROM site_content;
        ";

        try {
            $statement = $this->conn->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            return 'Error:'.$e->getMessage();
        }
    }

    public function getOneContent($id)
    {
        $query = "
            SELECT * FROM site_content WHERE id = ? ;
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

    public function UpdateContent($id, $new_count)
    {
        $query = "
            UPDATE site_content
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

    public function deleteContent($id)
    {
        $query = "
            DELETE FROM site_content
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
