<?php

$filePath = __DIR__.'/Resources/storage/siteContent.json';

$jsonData = file_get_contents($filePath);
$rawData = json_decode($jsonData);

insertData($filePath);

function insertData($filePath)
{
    if (!file_exists($filePath)) {
        echo "File path $filePath does not exist";
        return false;
    }
    $content = array("site_content" => array(
        'banner_heading' => '',
        'banner_text' => '',
        'about_essay' => '',
        'email' => '',
        'phone' => '',
        'facebook_url' => '',
        'instagram_url' => '',
        'twitter_url' => '',
        'whatsapp_no' => '',
        'address' => '',
        'last_modified' => date('Y-m-d H:i:s')
    ));

    $jsonContent = json_encode($content, JSON_PRETTY_PRINT);
    $result = file_put_contents($filePath, $jsonContent);
    echo $result;
    // $decodedJson = json_decode($jsonContent);
    // var_dump($decodedJson->site_content->last_modified);
}