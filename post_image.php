<?php
ini_set('display_errors', '1');

require_once('dbinfoset.php');
require_once('Post_class.php');

$post = Post::findby('id', $_GET['post_id']);

header("Content-Type: {$post->image_type}");
echo $post->image;