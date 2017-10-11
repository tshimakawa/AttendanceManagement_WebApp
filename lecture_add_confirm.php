<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="lecture_add_confirm.css" type="text/css">
<body>
<?php
session_start(); #セッション開始
mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

if($_POST['access'] != "true" and $_SESSION['login'] != true ){#ログインせずにアクセスした場合
	header("Location:login.php");
	exit;
}

if($_POST['Year'] == null or $_POST['Term'] == null or $_POST['Weekday'] == null or $_POST['Time'] == null or $_POST['Name'] == null  or $_POST['room_name'] == null or $_POST['attend_start'] == null or $_POST['attend_end'] == null) {
	$_SESSION['lecture_add'] = 1;
	header("Location:lecture_add.php");
	exit;
}
else {
	$_SESSION['lecture_add'] = 0;
	$_SESSION['Year'] = $_POST['Year'];
	$_SESSION['Term'] = $_POST['Term'];
	$_SESSION['Weekday'] = $_POST['Weekday'];
	$_SESSION['Time'] = $_POST['Time'];
	$_SESSION['Name'] = $_POST['Name'];
	$_SESSION['room_name'] = $_POST['room_name'];
	$_SESSION['attend_start'] = $_POST['attend_start'];
	$_SESSION['attend_end'] = $_POST['attend_end'];
}
echo '<div class = "confirm_box">';
echo '<br>'.'<font size="6">講義登録の内容確認</font>'.'<br>';

echo  '<br>'.'講義年度：'.$_POST['Year'].'<br>';
echo  '<br>'.'講義学期：'.$_POST['Term'].'<br>';
if($_POST['Weekday'] == 0) {
		echo  '<br>'.'講義曜日：日曜日'.'<br>';
	}
	elseif($_POST['Weekday'] == 1) {
		echo  '<br>'.'講義曜日：月曜日'.'<br>';
	}
	elseif($_POST['Weekday'] == 2) {
		echo  '<br>'.'講義曜日：火曜日'.'<br>';
	}
	elseif($_POST['Weekday'] == 3) {
		echo  '<br>'.'講義曜日：水曜日'.'<br>';
	}
	elseif($_POST['Weekday'] == 4) {
		echo  '<br>'.'講義曜日：木曜日'.'<br>';
	}
	elseif($_POST['Weekday'] == 5) {
		echo  '<br>'.'講義曜日：金曜日'.'<br>';
	}
	elseif($_POST['Weekday'] == 6) {
		echo  '<br>'.'講義曜日：土曜日'.'<br>';
	}
echo '<br>'.'講義時限：'.$_POST['Time'].'時限'.'<br>';
echo '<br>'.'講義名：'.$_POST['Name'].'<br>';
echo '<br>'.'講義教室：'.$_POST['room_name'].'<br>';
echo '<br>'.'出席受付開始時間：'.$_POST['attend_start'].'<br>';
echo '<br>'.'出席受付終了時間：'.$_POST['attend_end'].'<br>';

echo  '<br>'.'<br>'.'<font size="4">上記の条件で登録しますか？</font>'.'<br>';

echo '<form action="lecture_add_comp.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo '<br>'.'<button class="button" type="submit" name="registration" value = "登録">登録</button>';
echo '</form>';
echo '<form action="lecture_add.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo '<br>'.'<button class="cansel_button" type="submit" name="registration" value = "変更">変更</button>';
echo '</form>';
echo '</div>';

?>
</body>
</html>
