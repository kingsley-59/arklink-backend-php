<?php

    // private function _findAll()
    // {
    //     $fileContent = file_get_contents($this->jsonFilePath);

    //     $response['status_code_header'] = 'HTTP/1.1 200 OK';
    //     $response['body'] = json_decode($fileContent);
    //     return $response;
    // }

    // private function _findOne($key)
    // {
    //     $fileContent = file_get_contents($this->jsonFilePath);
    //     $siteContent = json_decode($fileContent);
    //     $result = (isset($siteContent->site_content->$key)) ? $siteContent->site_content->$key : $siteContent->site_content;
    //     $response['status_code_header'] = 'HTTP/1.1 200 OK';
    //     $response['body'] = $result;
    //     return $response;
    // }


    // /* 
    //     Schema = {
    //         "site_content": {
    //             "banner_heading": "",
    //             "banner_text": "",
    //             "about_essay": "",
    //             "email": "",
    //             "phone": "",
    //             "facebook_url": "",
    //             "instagram_url": "",
    //             "twitter_url": "",
    //             "whatsapp_no": "",
    //             "address": "",
    //             "last_modified": "2022-04-21 17:28:21"
    //         }
    //     }
    // */
    // private function _create()
    // {
    //     $input = (array) json_decode(file_get_contents('php://input'), TRUE);
    //     $input = $this->sanitizeInput($input);
    //     $response['status_code_header'] = 'HTTP/1.1 201 Created';
    //     $response['body'] = $input;
    //     return $response;
    // }

    // private function _update()
    // {

    // }

    // private function _delete()
    // {

    // }
