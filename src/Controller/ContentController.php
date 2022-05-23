<?php
namespace App\Controller;

//require  __DIR__.'/BaseController.php';
//require  __DIR__.'/../Model/ContentModel.php';


use App\Controller\BaseController;
use App\Model\Content;


class ContentController extends BaseController
{
    private $contentModel;
    private $jsonFilePath;
    
    public function processRequest()
    {
        $id = (isset($this->uri[3])) ? $this->uri[3] : null;

        $this->contentModel = new Content();
        $this->jsonFilePath = __DIR__."/../Resources/storage/siteContent.json";
        if (!file_exists($this->jsonFilePath)) {
            echo json_encode($this->dataFileNotFound());
            return;
        }

        switch ($this->requestMethod) {
            case 'GET':
                if ($id) {
                    $response = $this->_findOne($id);
                } else {
                    $response = $this->_findAll();
                }
                break;

            case 'POST':
                $response = $this->_create();
                break;

            case 'PUT':
                $response = $this->_update();
                break;

            case 'DELETE':
                $response = $this->_delete();
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

    private function _findAll()
    {
        $fileContent = file_get_contents($this->jsonFilePath);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_decode($fileContent);
        return $response;
    }

    private function _findOne($key)
    {
        $fileContent = file_get_contents($this->jsonFilePath);
        $siteContent = json_decode($fileContent);
        $result = (isset($siteContent->site_content->$key)) ? $siteContent->site_content->$key : $siteContent->site_content;
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    private function _create()
    {
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function _update()
    {

    }

    private function _delete()
    {

    }

    private function findAll()
    {
        $result = $this->contentModel->getAllContent();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function findOne($id)
    {
        $result = $this->contentModel->getOneContent($id);
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
        $result = $this->contentModel->createContent($input);
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