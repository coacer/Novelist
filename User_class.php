<?php
require('password_functions.php');
class User {
  
  protected static $table_name = 'users'; // テーブル名定義
  public $id;
  public $name;
  public $email;
  public $password;

  //クラスメソッド

  // Userインスタンス生成メソッド
  public function __construct($name, $email, $password) {

      // 値をプロパティに格納
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
  }

  // データ抽出メソッド
  public static function findBy($colName, $value) {
    try {

      global $pdo; // 'dbinfoset.php'の$pdoをグローバル定義
      $table_name = self::$table_name;
      $sql = "SELECT * FROM {$table_name} where {$colName}='{$value}'";
      $result = $pdo->query($sql);
      $result = $result->fetch();
      
      $new_user = new self($result['name'], $result['email'], $result['password']);
      $new_user->id = $result['id'];

      return $new_user;
      
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } 

  // インスタンスメソッド

  //インスタンス保存メソッド
  public function save() {
    try {
      global $pdo; // 'dbinfoset.php'の$pdoをグローバル定義
      $table_name = self::$table_name;
      // emailの被りがないか検証
      $sql = "SELECT email FROM {$table_name} where email='{$this->email}'";
      $result = $pdo->query($sql);
      $result = $result->fetch();

      if ($result) {
        return false;
      }
      
      // DBに値を格納
      $sql = $pdo->prepare("INSERT INTO {$table_name} (name, email, password) VALUES (:name, :email, :password)");
      $sql->bindParam(':name', $this->name);
      $sql->bindParam(':email', $this->email);
      $sql->bindParam(':password', password_hash($this->password)); // passwordをハッシュ化して保存
      $sql->execute();

      $this->id = $pdo->lastinsertid(); // idをプロパティに代入
      return true;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
}

?>