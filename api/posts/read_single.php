<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);
$post->id = isset($_GET['id']) ? $_GET['id'] : die('There no id parametr');

$row = $post->readSingle();
$postArr = array(
  'id' => $post->id,
  'title' => $post->title,
  'text' => html_entity_decode($post->text),
  'author' => $post->author,
  'categoryID' => $post->categoryID,
  'categoryName' => $post->categoryName
);

print_r(json_encode($postArr));
