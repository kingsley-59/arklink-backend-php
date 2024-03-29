<?php
namespace App\Controller;

//require __DIR__.'/BaseController.php';
//require __DIR__.'/../Model/CategoryModel.php';


use App\Controller\BaseController;
use App\Model\Product;


class ProductController extends BaseController
{
    private $productModel;
    public function processRequest()
    {
        $id = (isset($this->uri[3])) ? $this->uri[3] : null;
        // if (! isset($id)) {
        //     echo json_encode($this->unprocessableEntity());
        // }
        $this->productModel = new Product();
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
                if ($id) {
                    $response = $this->update($id);
                } else {
                    $response = $this->unprocessableEntity();
                }
                break;

            case 'DELETE':
                $response = $this->delete($id);
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
        $result = $this->productModel->getAllProducts();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    private function findOne($id)
    {
        $result = $this->productModel->getOneProduct($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    private function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = $this->sanitizeInput($input);
        $result = $this->productModel->createProduct($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    private function update($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = $this->sanitizeInput($input);
        $result = $this->productModel->updateProduct($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    private function delete($id)
    {
        $result = $this->productModel->deleteProduct($id);
        $response['status_code_header'] = 'HTTP/1.1 200 Created';
        $response['body'] = $result;
        return $response;
    }
}
