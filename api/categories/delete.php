<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: DELTE');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

if ($category->delete()) {
  print_r(json_encode(
    array('message' => 'Category deleted')
  ));
} else {
  http_response_code(400);
  print_r(json_encode(
    array('message' => 'Category did not delete')
  ));
}
