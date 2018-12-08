<?php

session_start();

require_once('dbinfoset.php');
require_once('User_class.php'); // Userモデル読み込み
require_once('Post_class.php'); // Postモデル読み込み
require_once('functions.php');

if (!loginState()) {
  header('location: login.php');
  exit();
}

$post = Post::findby('id', $_GET['post_id']);
$current_user = current_user();
if ($post->user_id == $current_user->id) {
  $post->delete();
  setFlash("投稿を削除しました");
}
header('location: posts_index.php');