<?php 
require_once('header.php'); // ヘッダー読み込み

// ログイン状態確認処理
if (loginState()) {
  header('location: posts_index.php');
  exit();
}
?>

<main>
  <article class="article top-article">
    <div class="top-box">
      <h2 class="top-title">Novelist</h2>
      <p>短編小説を自由に投稿できるサイトです。小説家見習いの方、
      趣味で気軽に小説作りに<br>
      挑戦したい方、自由に使ってみよう！</p>
      <div class="top-link-box">
        <a href="signup.php">Sign up</a><br>
        <a href="login.php">Log in</a>
      </div>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>