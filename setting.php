<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="setting.css" type="text/css">
<body>
<?php
session_start(); #セッション開始

if($_SESSION['login'] != true ){#ログインしていない状態でのアクセスの場合
	header("Location:login.php");
	exit;
}

#不適切な入力があった時にエラー文を表示
echo '<div align="center">';
echo'<br>';
if($_SESSION['setting_result'] == 1) {
	echo '<FONT COLOR="RED"> ユーザーID，またはパスワードが正しくありません </FONT>'.'<br>';
}
elseif($_SESSION['setting_result'] == 2) {
	echo '<FONT COLOR="RED"> 新しいユーザーID，または新しいパスワードの形式が正しくありません </FONT>'.'<br>';
}
else {
	echo'<br>';
}
echo '</div>';
echo'<br>';

#入力用フォーマット
echo '<div class="setting_box">';
echo '<form action="setting_judge.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo "現在のユーザーID".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="login_id" value="">'.'<br>';
echo '<br>';
echo "現在のパスワード".'<br>';
echo '<input class="text" type ="password" autocomplete="off"  name="pass" value="">'.'<br>';
echo '<br>';
echo "新しいユーザーID（英数字8文字以上）".'<br>';
echo '<input class="text" type ="text" autocomplete="off"  name="new_login_id" value="">'.'<br>';
echo '<br>';
echo "新しいパスワード（英数字8文字以上）".'<br>';
echo '<input class="text" type ="text" autocomplete="off"  name="new_pass" value="">'.'<br>';
echo '<br>';
echo '<button class="button" type="submit" name="login" value = "OK">OK</button>';
echo '</form>';
echo'<br>';
echo '<form action="login_attendance.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="back_button" type="submit" name="action" value="lecture">戻る</button>';
echo '</form>';
echo '</div>';

?>
</body>
</html>
