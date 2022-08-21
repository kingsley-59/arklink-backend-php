<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__.'/src/Model/Database.php';
require __DIR__.'/src/Auth/AuthMiddleware.php';

use App\Model\Database;

$allHeaders = getallheaders();
$db_connection = new Database();
$conn = $db_connection->getConnection();

$auth = new Auth($conn, $allHeaders);

echo json_encode($auth->isValid());