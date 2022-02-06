<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: DELTE');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->id = $data->id;

if ($post->delete()) {
  print_r(json_encode(
    array('message' => 'Post deleted')
  ));
} else {
  http_response_code(400);
  print_r(json_encode(
    array('message' => 'Post did not delete')
  ));
}
