<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="prof_add.css" type="text/css">
<body>
<?php
session_start(); #セッション開始
mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

echo '<div class = "lecture_box">';

if($_SESSION['prof_add'] == 1) {
	echo 'すべての欄を記入してください';
}
elseif($_SESSION['prof_add'] == 3) {
	echo 'パスワードが一致しません';
}
elseif($_SESSION['prof_add'] == 2) {
	echo 'ログインIDが一致しません';
}
elseif($_SESSION['prof_add'] == 4) {
	echo 'ログインID，パスワードの形式が不適切です';
}
else {
	echo '<br>';
}

echo '<form action="prof_add_comp.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo '<br>'."氏名（性と名の間にスペース不要）".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="Name" value="">'.'<br>';
echo '<br>'."ログインID（英数字8文字以上）".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="Log_ID" value="">'.'<br>';
echo '<br>'."パスワード（英数字8文字以上）".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="pass" value="">'.'<br>';
echo '<br>'."ログインID（確認用）".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="Log_ID_confirm" value="">'.'<br>';
echo '<br>'."パスワード（確認用）".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="pass_confirm" value="">'.'<br>';
echo '<br>'.'<button class="button" type="submit" name="registration" value = "登録">登録</button>';
echo '</form>';
echo '<form action="login.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo '<br>'.'<br>'.'<button class="backbutton" type="submit" name="registration" value = "戻る">ログイン画面に戻る</button>';
echo '</form>';
echo '</div>';

?>
</body>
</html>
