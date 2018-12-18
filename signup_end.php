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
    <div class="check-box">
      <h2 class="check-title">登録完了画面</h2>
      <hr>
      <p>登録が完了しました</p>
      <a href="#">Novelistをはじめる</a>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>