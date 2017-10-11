<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="setting_finish.css" type="text/css">
<body>
<?php
session_start(); #セッション開始

if($_SESSION['login'] != true ){#ログインしていない状態でのアクセスの場合
	header("Location:login.php");
	exit;
}

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
echo '<ユーザーID，パスワードの変更が完了しました>'.'<br>';
echo '操作を続ける場合は'.'<br>'.'ログイン画面へ戻り再ログインしてください'.'<br>';
echo '<br>';
echo '<div class="button">';
echo '<form action="login.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="back_login" type="submit" name="action" value="lecture">ログイン画面へ戻る</button>';
echo '</form>';
echo '</div>';
echo '</div>';

?>
</body>
</html>
