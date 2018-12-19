<?php 
require_once('header.php'); // ヘッダー読み込み


// ログイン状態, セッション情報確認処理
if (loginState()) {
  header('location: posts_index.php');
  exit();
} else if (empty($_SESSION['email'])) {
  header('location: index.php');
}

$user = User::findBy('email', $_SESSION['email'], 0);
$user->active();
session_destroy();


$mailTo = $user->email;
      
	    //Return-Pathに指定するメールアドレス
      $returnMail = 'web@sample.com';
    
      $name = "Novelist";
      $mail = 'web@sample.com';
      $subject = "【Novelist】会員登録完了のお知らせ";
      $user_name = $user->name;
      
$body = <<< EOM
会員登録が完了しました。
以下がユーザー情報になります。

ユーザー名: {$user_name}
メールアドレス: {$mailTo}


-----------------------------------------------------------
Novelist: http://tt-701.99sv-coco.com/mission_6-1/index.php
EOM;

      mb_language('ja');
      mb_internal_encoding('UTF-8');
    
      //Fromヘッダーを作成
      $header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';
    
      mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)
      
?>

<main>
  <article class="article top-article">
    <div class="check-box">
      <h2 class="check-title">登録完了画面</h2>
      <hr>
      <p>登録が完了しました</p>
      <a href="posts_index.php">Novelistをはじめる</a>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>