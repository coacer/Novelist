<?php
session_start();
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : '';
unset($_SESSION['flash']);

require_once('dbinfoset.php');
require_once('User_class.php'); // Userモデル読み込み
require_once('Post_class.php'); // Postモデル読み込み
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Novelist</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <h1><a href="index.php">Novelist</a></h1>
<?php 
      $current_user = current_user();
      if (empty($current_user)) : ?>
      <ul>
        <li><a href="signup.php">sign up</a></li>
        <li><a href="login.php">login</a></li>
      </ul>
<?php else : ?>
      <ul>
        <li><a href="posts_index.php">home</a></li>
        <li><a href="post_create.php">new book</a></li>
        <li><a href="logout.php">logout</a></li>
      </ul>
<?php endif; ?>
    </nav>
  </header>
<?php // $flash = "これはフラッシュメッセージです。"; ?>
<?php if (!empty($flash)) : ?>
  <div class="flash">
    <?= $flash ?>
  </div>
<?php endif; ?>