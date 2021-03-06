<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->name = $data->name;

if ($category->create()) {
  print_r(json_encode(
    array('message' => 'Category created')
  ));
} else {
  http_response_code(400);
  print_r(json_encode(
    array('message' => 'Category not created')
  ));
}
