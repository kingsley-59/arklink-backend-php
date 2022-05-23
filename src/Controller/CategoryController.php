<?php
namespace App\Controller;

//require __DIR__.'/BaseController.php';
//require __DIR__.'/../Model/CategoryModel.php';


use App\Controller\BaseController;
use App\Model\Category;


class CategoryController extends BaseController
{
    private $categoryModel;
    public function processRequest()
    {
        $id = (isset($this->uri[3])) ? $this->uri[3] : null;
        // if (! isset($id)) {
        //     echo json_encode($this->unprocessableEntity());
        // }
        $this->categoryModel = new Category();
        switch ($this->requestMethod) {
            case 'GET':
                if ($id) {
                    $response = $this->findOne($id);
                } else {
                    $response = $this->findAll();
                }
                break;

            case 'POST':
                $response = $this->create();
                break;

            case 'PUT':
                $response = $this->update();
                break;

            case 'DELETE':
                $response = $this->delete();
                break;
            
            default:
                parent::unprocessableEntity();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo json_encode($response['body']);
        }
    }

    private function findAll()
    {
        $result = $this->categoryModel->getAllCategory();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function findOne($id)
    {
        $result = $this->categoryModel->getOneCategory($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = $this->sanitizeInput($input);
        $result = $this->categoryModel->createCategory($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    private function update()
    {

    }

    private function delete()
    {

    }
}
