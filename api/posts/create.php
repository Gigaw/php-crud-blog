<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->text = $data->text;
$post->author = $data->author;
$post->categoryID = $data->categoryID;

if ($post->create()) {
  print_r(json_encode(
    array('message' => 'Post created')
  ));
} else {
  http_response_code(400);
  print_r(json_encode(
    array('message' => 'Post not created')
  ));
}
