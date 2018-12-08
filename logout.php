<?php
require_once('header.php'); // ヘッダー読み込み

if (loginState()) {
  logout();
} else {
  header('location: login.php');
  exit();
}

?>

<main>
  <article class="article top-article">
    <div class="form-box">
      <h2 class="form-title">ログアウトしました</h2>
      <a href="login.php">ログイン画面に戻る</a>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>