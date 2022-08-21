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

    /*
        This will create a new version of the website content from request data and save to database
        @params null
        @return response with status code and body.
    */
    private function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);   // get http request data
        $input = $this->sanitizeInput($input);                                  // sanitize data content
        $result = $this->contentModel->createContent($input);                   // pass sanitized content to model for save to db
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    /*
        This will return the latest version of the site contents by default
        @params null
        @return response with status code and body.
    */
    private function findAll()
    {
        $result = $this->contentModel->getAllContent();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        // $response['body'] = json_encode($result);
        $response['body'] = $result[0];
        return $response;
    }

    /*
        This will return a version of the site contents given the id of the version
        @params id
        @return response with status code and body.
    */
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

    /*
        Update and delete functions won't be needed because any update creates a new set of values
        This is to enable version tracking and backup as well as ease when reverting to previous content
    */
    private function update()
    {

    }

    private function delete()
    {

    }
}