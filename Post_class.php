<?php

class Post {
  protected static $table_name = 'posts'; // テーブル名定義
  public $id;
  public $title;
  public $description;
  public $image;
  public $image_type;
  public $body;
  public $user_id;

  // Postインスタンス生成メソッド
  public function __construct($post) {
    try{

      // 値をプロパティに格納
      
      $this->title = $post['title'];
      $this->description = $post['description'];
      $this->image = $post['image'];
      $this->image_type = $post['image_type'];
      $this->body = $post['body'];
      $this->user_id = $post['user_id'];

    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // クラスメソッド
  
  // 全データ取得メソッド
  public static function all() {
    try {
      global $pdo;
      $table_name = self::$table_name; // sql分に直接書き込めないので変数格納
      $sql = "SELECT * FROM {$table_name}";
      $result = $pdo->query($sql);
      $result = $result->fetchAll();
      return $result;
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  // データ抽出メソッド
  public static function findBy($colName, $value) {
    try {

      global $pdo; // 'dbinfoset.php'の$pdoをグローバル定義
      $table_name = self::$table_name; // sql分に直接書き込めないので変数格納
      $sql = "SELECT * FROM {$table_name} where {$colName}={$value}";
      $result = $pdo->query($sql);
      $result = $result->fetch();
      
      $new_post = new self($result);
      $new_post->id = $result['id'];

      return $new_post;
      
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // インスタンスメソッド

  // インスタンス保存メソッド
  public function save() {
    try {

     // DBに値を格納
     global $pdo; // 'dbinfoset.php'の$pdoをグローバル宣言
     $table_name = self::$table_name; // sql分に直接書き込めないので変数格納
     $sql = $pdo->prepare("INSERT INTO {$table_name} (title, description, image, image_type, body, user_id) VALUES (:title, :description, :image, :image_type, :body, :user_id)");
     $sql->bindParam(':title', $this->title);
     $sql->bindParam(':description', $this->description);
     $sql->bindParam(':image', $this->image);
     $sql->bindParam(':image_type', $this->image_type);
     $sql->bindParam(':body', $this->body);
     $sql->bindParam(':user_id', $this->user_id);
     $sql->execute();

     $this->id = $pdo->lastinsertid();

    return true;

    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // データ更新メソッド
  public function update($post) {
    try{

      // DBに値を格納
      global $pdo; // 'dbinfoset.php'の$pdoをグローバル宣言
      $table_name = self::$table_name; // sql分に直接書き込めないので変数格納
      $sql = $pdo->prepare("UPDATE {$table_name} SET title=:title, description=:description, image=:image, image_type=:image_type, body=:body where id='{$this->id}'");
      $sql->bindParam(':title', $post['title']);
      $sql->bindParam(':description', $post['description']);
      $sql->bindParam(':image', $post['image']);
      $sql->bindParam(':image_type', $post['image_type']);
      $sql->bindParam(':body', $post['body']);
      $sql->execute();

      // 値をプロパティに格納
      $this->title = $post['title'];
      $this->description = $post['description'];
      $this->image = $post['image'];
      $this->image_type = $post['image_type'];
      $this->body = $post['body'];

    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // データ削除メソッド
  public function delete() {
    global $pdo;
    $table_name = self::$table_name;
    $sql = "DELETE FROM $table_name where id='$this->id'";
    $pdo->query($sql);
  }

}