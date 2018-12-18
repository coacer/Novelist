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
      <h2 class="check-title">メールの送信を完了しました</h2>
      <hr>
      <p>メールをお送りしました。</p>
      <p>24時間以内にメールに記載されたURLからご登録下さい。</p>
      
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>