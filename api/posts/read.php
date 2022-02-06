<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$result = $post->read();
$num = $result->rowCount();

if($num > 0){
  $postsArr = array();
  $postsArr['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $postItem = array(
      'id' => $id,
      'title' => $title,
      'text' => html_entity_decode($text),
      'author' => $author,
      'categoryID' => $category_id,
      'categoryName' => $category_name
    );
    array_push($postsArr['data'], $postItem);
  }

  echo json_encode($postsArr);
} else {
  echo json_encode(array('message' => 'No posts found'));
}
