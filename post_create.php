<?php
require_once('header.php'); // ヘッダー読み込み

// ログイン状態確認処理
if (!loginState()) {
  header('location: login.php');
  exit();
}

// 編集用URLパラメータが送られてきた場合
if (!empty($_GET['post_id'])) {
  $edit_post = Post::findby('id', $_GET['post_id']);
  $current_user = current_user();
  $form_action = "post_create.php?post_id={$edit_post->id}"; // formからpostを送る先格納
  if ($edit_post->user_id !== $current_user->id) {
    header('location: posts_index.php');
    exit();
  } else {
    $title = $edit_post->title;
    $description = $edit_post->description;
    $body = $edit_post->body;
    $post_id = $edit_post->id;
  }
} else {
  $form_action = "post_create.php"; // formからpostを送る先格納
  // 変数初期化
  $title = '';
  $description = '';
  $image = '';
  $body = '';
  $post_id = '';
}
  

$post = array();
if (!empty($_POST['submit'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $body = $_POST['body'];

  if (empty($_POST['title'])) {
    $error_message = "タイトルを入力してください";
  } else if (empty($_POST['description'])) {
    $error_message = "詳細を入力してください";
  } else if (empty($_FILES['image'])) {
    $error_message = "画像を指定してください";
  } else if ($_FILES['image']['size'] > 1024*1024) {
    $error_message = "1MB以上の画像は指定できません";
  } else if (empty($_POST['body'])) {
    $error_message = "本文を入力してください";
  } else {
    $upfile = $_FILES['image']['tmp_name'];
    $image = file_get_contents($upfile);
    $image_type = $_FILES['image']['type'];
    if (empty($_POST['edit_mode'])) {
      // 投稿処理
      $user = current_user(); // ユーザーオブジェクト取得
      $user_id = $user->id;

      $post = array('title' => $title,
                    'description' => $description,
                    'image' => $image,
                    'image_type' => $image_type,
                    'body' => $body,
                    'user_id' => $user_id
                  );
      $new_post = Post::create($post); // postを新規作成
      setFlash("投稿しました");
      header("location: post_show.php?post_id={$new_post->id}");
      exit();
    } else {
    // 編集処理
      $edit_post = Post::findby('id', $_GET['post_id']);
      $post = array('title' => $title,
                    'description' => $description,
                    'image' => $image,
                    'image_type' => $image_type,
                    'body' => $body,
                  );
      $edit_post->update($post);
      setFlash("編集しました");
      header("location: post_show.php?post_id={$edit_post->id}");
      exit();
    }
  
  }
}

?>

<main>
  <article class="article main-article">
    <div class="main-box">
<!-- 表示切り替え -->
<?php if (empty($_GET['post_id'])) : ?>
        <h2>New Book</h2>
<?php else : ?>
        <h2>Edit Book</h2>
<?php endif; ?>
        <hr>
        <section class="post post-form">
          <p class="error-resize error"><?= $error_message ?></p>
          <form action="<?= $form_action ?>" enctype="multipart/form-data" method="post">
            <label for="title">タイトル</label><br>
            <input type="text" name="title" id="title" value="<?= $title ?>" placeholder="タイトルを入力してください"><br>
            <label for="description">詳細</label><br>
            <textarea name="description" id="description" cols="30" rows="10"  placeholder="簡単な詳細をを入力してください"><?= $description ?></textarea><br>
            <label for="image">イメージ画像</label><br>
            <input type="file" name="image" id="image"><br>
            <label for="body">本文</label><br>
            <textarea name="body" id="body" cols="30" rows="10" placeholder="本文を入力してください"><?= $body ?></textarea>
            <input type="hidden" name="edit_mode" value="<?= $post_id ?>">
            <input type="submit" name="submit" value="投稿" class="post-submit">
          </form>
        </section>
    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>