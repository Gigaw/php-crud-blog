<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$result = $category->read();
$num = $result->rowCount();

if($num > 0){
  $categoriesArr = array();
  $categoriesArr['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $categoriesItem = array(
      'id' => $id,
      'name' => $name
    );
    array_push($categoriesArr['data'], $categoriesItem);
  }

  echo json_encode($categoriesArr);
} else {
  echo json_encode(array('message' => 'No posts found'));
}
