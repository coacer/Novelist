<?php 
require_once('header.php'); // ヘッダー読み込み


// ログイン状態, URLパラメータ確認
if (loginState()) {
  header('location: posts_index.php');
  exit();
} else if (empty($_GET['urltoken'])) {
  header('location: index.php');
  exit();
}

$urltoken = $_GET['urltoken'];

$user = User::findByUrltoken($urltoken);
var_dump($user);
?>

<main>
  <article class="article top-article">
    <div class="check-box">
<?php if (!empty($user->id)) :
      $_SESSION['email'] = $user->email; ?>

      <h2 class="check-title">登録確認画面</h2>
      <hr>
      <p>name: <?= $user->name ?></p>
      <p>email: <?= $user->email ?></p>
      <a href="signup_end.php">確認完了</a>
<?php else: 
      $error_message = "このURLはご利用できません。有効期限が過ぎた等の問題があります。
                        もう一度登録をやりなおして下さい"; ?>
      <p class="error"><?= $error_message ?></p>
<?php endif; ?>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>