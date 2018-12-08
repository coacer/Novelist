<?php 
require_once('header.php'); // ヘッダー読み込み


// ログイン状態確認処理
if (loginState()) {
  header('location: posts_index.php');
  exit();
}

// 変数初期化
$username = '';
$email = '';
$password = '';
$password_confirmation = '';

// 新規登録処理
if (!empty($_POST['signup'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_confirmation = $_POST['password_confirmation'];
  if (!empty($username) && !empty($email) && !empty($password) && !empty($password_confirmation) && $password === $password_confirmation) {
    $user = User::create($username, $email, $password);
    if($user->save()) {
      login($user);
      setFlash("新規登録が完了しました");
      header('location: posts_index.php');
    } else {
      $error_message = "このメールアドレスは既に登録済みです";
    }
  } else if ($password !== $password_confirmation) {
    $error_message = "パスワードに誤りがあります";
  } else {
    $error_message = "入力してください";
  }
} 
?>

<main>
  <article class="article top-article">
    <div class="form-box">
      <h2 class="form-title">新規登録フォーム</h2>
      <hr>
      <p class="error"><?= $error_message ?></p>
      <form action="signup.php" method="post">
        <label for="username">ユーザー名</label><br>
        <input type="text" name="username" id="username" value="<?= $username ?>" placeholder="ユーザー名を入力してください"><br>
        <label for="email">メールアドレス</label><br>
        <input type="email" name="email" id="email" value="<?= $email ?>" placeholder="メールアドレスを入力してください"><br>
        <label for="password">パスワード</label><br>
        <input type="password" name="password" id="password" value="<?= $password ?>" placeholder="パスワードを入力してください"><br>
        <label for="password-confirmation">パスワード再入力</label><br>
        <input type="password" name="password_confirmation" id="password-confirmation" value="<?= $password_confirmation ?>" placeholder="パスワードを再入力してください"><br>
        <input type="submit" name="signup" value="登録" class="submit">
      </form>
      <a href="login.php">ログインフォームへ</a>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>