<?php

class Post
{
  private $conn;
  private $table = 'posts';

  public $id;
  public $categoryID;
  public $categoryName;
  public $title;
  public $author;
  public $createdAT;
  public $text;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function read()
  {
    $query = "SELECT 
      c.name as category_name,
      p.id,
      p.category_id,
      p.title,
      p.text,
      p.author,
      p.text
      FROM {$this->table} p LEFT JOIN
      categories c ON p.category_id = c.id
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function readSingle()
  {
    $query = "SELECT 
      c.name as category_name,
      p.id,
      p.category_id,
      p.title,
      p.text,
      p.author,
      p.text
      FROM {$this->table} p LEFT JOIN
      categories c ON p.category_id = c.id
      WHERE
      p.id = ?
      LIMIT 0,1
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->title = $row['title'];
    $this->text = $row['text'];
    $this->author = $row['author'];
    $this->categoryID = $row['category_id'];
    $this->categoryName = $row['category_name'];

    return $stmt;
  }

  public function create()
  {
    $query = "INSERT INTO 
    {$this->table}
    SET
    title = :title,
    text = :text,
    author = :author,
    category_id = :category_id";

    $stmt = $this->conn->prepare($query);

    $this->title =  htmlspecialchars(strip_tags($this->title));
    $this->text =  htmlspecialchars(strip_tags($this->text));
    $this->author =  htmlspecialchars(strip_tags($this->author));
    $this->categoryID =  htmlspecialchars(strip_tags($this->categoryID));

    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':text', $this->text);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->categoryID);

    if ($stmt->execute()) {
      return true;
    }

    print_r('Error: ', $stmt->error);

    return false;
  }

  public function update()
  {
    $query = "UPDATE 
    {$this->table}
    SET
    title = :title,
    text = :text,
    author = :author,
    category_id = :category_id
    WHERE
    id = :id";

    $stmt = $this->conn->prepare($query);

    $this->title =  htmlspecialchars(strip_tags($this->title));
    $this->text =  htmlspecialchars(strip_tags($this->text));
    $this->author =  htmlspecialchars(strip_tags($this->author));
    $this->categoryID =  htmlspecialchars(strip_tags($this->categoryID));

    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':text', $this->text);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->categoryID);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
      return true;
    }

    print_r('Error: ', $stmt->error);

    return false;
  }

  public function delete()
  {
    $query = "DELETE FROM {$this->table} WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()){
      return true;
    }

    print_r('Error: '. $stmt->error);

    return false;
  }
}
