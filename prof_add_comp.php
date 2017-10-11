<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="prof_add_comp.css" type="text/css">
<body>
<?php
session_start(); #セッション開始

mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

if($_POST['Name'] == null or $_POST['Log_ID'] == null or $_POST['pass'] == null or $_POST['Log_ID_confirm'] == null or $_POST['pass_confirm'] == null) {
	$_SESSION['prof_add'] = 1;
	header("Location:prof_add.php");
	exit;
}
if(mb_strlen($_POST['Log_ID'])<8 and mb_strlen($_POST['pass'])<8){
	$_SESSION['prof_add'] = 4;
	header("Location:prof_add.php");
	exit;
}
elseif($_POST['Log_ID'] != $_POST['Log_ID_confirm']){
	$_SESSION['prof_add'] = 2;
	header("Location:prof_add.php");
	exit;
}
elseif($_POST['pass'] != $_POST['pass_confirm']){
	$_SESSION['prof_add'] = 3;
	header("Location:prof_add.php");
	exit;
}

mysql_query('insert into prof(name,login_id,password) values("'.$_POST['Name'].'","'.$_POST['Log_ID'].'","'.$_POST['pass'].'")') or die(mysql_error());

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
echo '<アカウントの追加が完了しました>'.'<br>';
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
