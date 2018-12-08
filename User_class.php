<?php
require('password_functions.php');
class User {
  
  protected $table_name = 'users'; // テーブル名定義
  public $id;
  public $name;
  public $email;
  public $password;

  //クラスメソッド

  // Userインスタンス生成メソッド
  public static function create($name, $email, $password) {
    try{

      $new_user = new self; // インスタンス生成

      // 値をプロパティに格納
      $new_user->name = $name;
      $new_user->email = $email;
      $new_user->password = $password;

      return $new_user;

    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // データ抽出メソッド
  public static function findBy($colName, $value) {
    try {

      $new_user = new self;
      global $pdo; // 'dbinfoset.php'の$pdoをグローバル定義
      $sql = "SELECT * FROM {$new_user->table_name} where {$colName}='{$value}'";
      $result = $pdo->query($sql);
      $result = $result->fetch();

      $new_user->id = $result['id'];
      $new_user->name = $result['name'];
      $new_user->email = $result['email'];
      $new_user->password = $result['password'];

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

      // emailの被りがないか検証
      $sql = "SELECT email FROM {$this->table_name} where email='{$this->email}'";
      $result = $pdo->query($sql);
      $result = $result->fetch();

      if ($result) {
        return false;
      }
      
      // DBに値を格納
      $sql = $pdo->prepare("INSERT INTO {$this->table_name} (name, email, password) VALUES (:name, :email, :password)");
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