<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="logout.css" type="text/css">
<body>
<?php
session_start(); #セッション開始

#セッション変数を全て解除する
$_SESSION = array();

#セッションを切断するにはセッションクッキーも削除する。
#Note: セッション情報だけでなくセッションを破壊する。
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time(), '/');
}
#最終的に、セッションを破壊する
session_destroy();

echo '<div class="textbox">';
echo '<ログアウトが完了しました>'.'<br>';
echo 'おつかれさまでした';
echo '</div>';
?>
</body>
</html>
