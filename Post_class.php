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

  // クラスメソッド

  // Postインスタンス生成メソッド
  public static function create($post) {
    try{

      $new_post = new self; // インスタンス生成
      // DBに値を格納
      global $pdo; // 'dbinfoset.php'の$pdoをグローバル宣言
      $table_name = self::$table_name; // sql分に直接書き込めないので変数格納
      $sql = $pdo->prepare("INSERT INTO {$table_name} (title, description, image, image_type, body, user_id) VALUES (:title, :description, :image, :image_type, :body, :user_id)");
      $sql->bindParam(':title', $post['title']);
      $sql->bindParam(':description', $post['description']);
      $sql->bindParam(':image', $post['image'], PDO::PARAM_LOB);
      $sql->bindParam(':image_type', $post['image_type']);
      $sql->bindParam(':body', $post['body']);
      $sql->bindParam(':user_id', $post['user_id']);
      $sql->execute();

      // 値をプロパティに格納
      $new_post->id = $pdo->lastinsertid();
      $new_post->title = $post['title'];
      $new_post->description = $post['description'];
      $new_post->image = $post['image'];
      $new_post->image_type = $post['image_type'];
      $new_post->body = $post['body'];
      $new_post->user_id = $post['user_id'];

      return $new_post;

    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

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

      $new_post = new self;
      global $pdo; // 'dbinfoset.php'の$pdoをグローバル定義
      $table_name = self::$table_name; // sql分に直接書き込めないので変数格納
      $sql = "SELECT * FROM {$table_name} where {$colName}={$value}";
      $result = $pdo->query($sql);
      $result = $result->fetch();

      $new_post->id = $result['id'];
      $new_post->title = $result['title'];
      $new_post->description = $result['description'];
      $new_post->image = $result['image'];
      $new_post->image_type = $result['image_type'];
      $new_post->body = $result['body'];
      $new_post->user_id = $result['user_id'];

      return $new_post;
      
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // インスタンスメソッド

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