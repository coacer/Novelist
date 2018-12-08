<?php
require_once('header.php'); // ヘッダー読み込み

// ログイン状態確認処理
if (!loginState()) {
  header('location: login.php');
  exit();
}

// URLパラメータをキーにpostオブジェクト取得
$post = Post::findby('id', $_GET['post_id']);
$user = User::findby('id', $post->user_id);
?>

<main>
  <article class="article main-article">
    <div class="main-box">
        <h2>Description</h2>
        <hr>
        <section class="post post-body">
          <h3><?= $user->name ?></h3>
          <h4><?= $post->title ?></h4>
          <p><?= $post->description ?></p>
          <?php $image_url = "post_image.php?post_id={$post->id}"; ?>
          <img src="<?= $image_url ?>" alt="post image">
          <hr>
          <p><?= $post->body ?></p>
        </section>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>