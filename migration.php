<?php
try {
require('dbinfoset.php');


// usersテーブル作成
  $sql = "CREATE TABLE if not exists users (id INT NOT NULL auto_increment PRIMARY KEY,
                              name char(32) NOT NULL,
                              email char(100) NOT NULL unique,
                              password char(30) NOT NULL);";
  $stmt = $pdo->query($sql);

  // データベースカラム変更
  $sql = "ALTER TABLE users CHANGE password password char(100) NOT NULL";
  $stmt = $pdo->query($sql);

  $sql = "ALTER TABLE posts CHANGE image image LONGBLOB";
  $stmt = $pdo->query($sql);

  // $sql = "ALTER TABLE posts ADD image_type char(50) AFTER image";
  // $stmt = $pdo->query($sql);
  
  // データベースリセット
  // $sql ="DELETE FROM users";
  // $stmt = $pdo->query($sql);
  // $sql ="DELETE FROM posts";
  // $stmt = $pdo->query($sql);



  // データ挿入テスト
  // $name = 'name';
  // $email = 'email';
  // $password = 'password';

  // $sql = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
  // $sql->bindParam(':name', $name);
  // $sql->bindParam(':email', $email);
  // $sql->bindParam(':password', $password);
  // $sql->execute();

  // $sql = "select * from users";
  // $result = $pdo->query($sql);

  // var_dump($result);


// postsテーブル作成(あとでimageカラムを追加してから実行)
$sql = "CREATE TABLE IF NOT EXISTS posts (id INT NOT NULL auto_increment PRIMARY KEY,
                                         title char(32) NOT NULL,
                                         description TEXT NOT NULL,
                                         body TEXT NOT NULL,
                                         user_id INT NOT NULL,
                                         image BLOB);";
  $stmt = $pdo->query($sql);



} catch (PDOException $e) {
    echo $e->getMessage();
  }

  ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>マイグレーション</title>
</head>
<body>
  <?php
    // table一覧テスト
$sql ='SHOW TABLES';
$result = $pdo->query($sql);
foreach ($result as $row) {
  echo $row[0];
  echo "<br>";
}
echo "<hr>";

// User一覧
$sql = 'select * from users';
  $results = $pdo->query($sql);
  foreach ($results as $value) {
    echo $value['id'] . "<br>";
    echo $value['name'] . "<br>";
    echo $value['email'] . "<br>";
    echo $value['password'] . "<br>";
  }
  // $results = $results->fetchAll();

  // var_dump($results);

// Post一覧
$sql = 'select * from posts';
$results = $pdo->query($sql);
foreach ($results as $value) {
  echo $value['id'] . "<br>";
  echo $value['title'] . "<br>";
  echo $value['description'] . "<br>";
  // echo $value['image'] . "<br>";
  echo $value['image_type'] . "<br>";
  echo $value['body'] . "<br>";
  echo $value['user_id'] . "<br>";
}
  ?>
</body>
</html>