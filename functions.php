<?php

// ログイン
function login($user) {
  session_regenerate_id(true);
  $_SESSION['user_id'] = $user->id;
}

// ログアウト
function logout() {
  $_SESSION['user_id'] = '';
}

// ログインユーザー
function current_user() {
  if (!empty($_SESSION['user_id'])) {
    return User::findby("id", $_SESSION['user_id']);
  } else {
    return null;
  }
}

// フラッシュ
function setFlash($message) {
  $_SESSION['flash'] = $message;
}

// ログイン状態
function loginState() {
  $current_user = current_user();
  if (!empty($current_user)) {
    return true;
  } else {
    return false;
  }
}