<?php
require_once('header.php'); // ヘッダー読み込み

// ログイン状態確認処理
if (!loginState()) {
  header('location: login.php');
  exit();
}

// 一覧処理
$posts = Post::all();

?>

<main>
  <article class="article main-article">
    <div class="main-box">
        <h2>Books</h2>
        <hr>
<!-- 投稿がある場合 -->
<?php if ($posts) :
        foreach ($posts as $post) :
        $user = User::findby('id', $post['user_id']) // user_idを元にuserオブジェクトを取得 ?>
        <section class="post post-obj">
          <div class="post-flex-box">
            <h3><?= $user->name ?></h3>
      <?php if ($post['user_id'] === current_user()->id) : ?>
              <div class="edit-delete-wrapper">
                <a href="post_create.php?post_id=<?= $post['id'] ?>">編集</a>
                <a href="post_delete.php?post_id=<?= $post['id'] ?>" onClick="javascript:return confirm('本当に削除しますか？')">削除</a>
              </div>
      <?php endif; ?>
          </div>
          <h4><?= $post['title'] ?></h4>
          <div class="descriptions">
            <?php $image_url = "post_image.php?post_id={$post['id']}"; ?>
            <img src="<?= $image_url ?>" alt="post image">
            <p><?= $post['description'] ?></p>
          </div>
          <a href="post_show.php?post_id=<?= $post['id'] ?>">Read</a>
        </section>
  <?php 
        endforeach;
// 投稿がない場合
      else : ?>
      <div class="nonobj-message">
        <p>投稿がありません</p>
      </div>
<?php endif; ?>

    </div>
  </article>
</main>

<?php require_once('footer.php'); // フッター読み込み ?>