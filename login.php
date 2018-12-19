<?php 
require_once('header.php'); // ヘッダー読み込み

// ログイン状態確認処理
if (loginState()) {
  header('location: posts_index.php');
  exit();
}

// 変数初期化
$email = '';
$password = '';

if (!empty($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  if (empty($email)) {
    $error_message = "メールアドレスを入力してください";
  } else if (empty($password)) {
    $error_message = "パスワードを入力してください";
  } else {
    $user = User::findby('email', $email);
    if (password_verify($password, $user->password) && $user->activated == 1) {
      setFlash("ログインしました");
      login($user);
      header('location: posts_index.php');
    } else {
      $error_message = "メールアドレスかパスワードに誤りがあります";
    }
  }
}
?>

<main>
  <article class="article top-article">
    <div class="form-box">
      <h2 class="form-title">ログインフォーム</h2>
      <hr>
      <p class="error"><?= $error_message ?></p>
      <form action="login.php" method="post">
        <label for="email">メールアドレス</label><br>
        <input type="email" id="email" name="email" value="<?= $email ?>" placeholder="メールアドレスを入力してください"><br>
        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="password" value="<?= $password ?>" placeholder="パスワードを入力してください"><br>
        <input type="submit" name="login" value="ログイン" class="submit">
      </form>
      <a href="signup.php">新規登録フォームへ</a>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>