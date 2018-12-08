<?php
// パスワードハッシュ化
if (!function_exists(password_hash)) {
  function password_hash($password) {
    return sha1($password);
  }
}

// パスワード照合
if (!function_exists(password_verify)) {
  function password_verify($sended_password, $true_hash_password) {
    $sended_hash_password = sha1($sended_password);
    return $sended_hash_password == $true_hash_password;
  }
}

 ?>
