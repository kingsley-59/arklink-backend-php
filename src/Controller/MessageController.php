<?php
namespace App\Controller;

use App\Controller\BaseController;
use App\Model\Message;


class MessageController extends BaseController
{
    private $productModel;
    public function processRequest()
    {
        $id = (isset($this->uri[3])) ? $this->uri[3] : null;
        
        $this->productModel = new Message();
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->findAll();
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
        $result = $this->productModel->getAllMessages();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    private function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = $this->sanitizeInput($input);
        $result = $this->productModel->createMessage($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    private function update($id)
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $input = $this->sanitizeInput($input);
        $result = $this->productModel->updateMessage($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    private function delete($id)
    {
        $result = $this->productModel->deleteMessage($id);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }
}
