<?php 

namespace App\Controller;

class BaseController 
{
    public $requestMethod;
    public $uri;
    public $service;

    public function __construct($requestMethod, $uri)
    {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
    }

    public static function pdoExceptionHandler($message = "")
    {
        $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
        $response['body'] = json_encode([
            'message' => $message
        ]);
        return $response;
    }

    public static function unprocessableEntity()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    public static function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    public static function dataFileNotFound()
    {
        $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
        $response['body'] = json_encode([
            'error' => 'Data file not found.'
        ]);
        return $response;
    }

    public function sanitizeInput(Array $input)
    {
        $sanitizedInput = array();
        foreach ($input as $key => $value) {
            $sanitizedInput[$key] = htmlspecialchars(strip_tags($value));
        }
        return $sanitizedInput;
    }
}
