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
$_SESSION['setting_result'] = 0;

mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

$prof = mysql_query('SELECT password, login_id,name FROM prof');
while($prof_list = mysql_fetch_assoc($prof)){
	if($prof_list['password'] == $_POST['pass'] and $prof_list['login_id'] == $_POST['login_id']){
		if(mb_strlen($_POST['new_pass'])>=8 and mb_strlen($_POST['new_login_id'])>=8){
			$prof_id_list = mysql_query('UPDATE prof SET password = "'.$_POST['new_pass'].'" where login_id = "'.$_POST['login_id'].'"');
			$prof_id_list = mysql_query('UPDATE prof SET login_id = "'.$_POST['new_login_id'].'" where login_id = "'.$_POST['login_id'].'"');
			$_SESSION['setting_result'] = 3;
		}
		else {
			$_SESSION['setting_result'] = 2;
		}
	}
}

if($_SESSION['setting_result'] == 3) {
	header("Location:setting_finish.php");
	exit;
}
elseif($_SESSION['setting_result'] == 2) {
	header("Location:setting.php");
	exit;
}
else {
	$_SESSION['setting_result'] = 1;
	header("Location:setting.php");
	exit;
}
?>
</body>
</html>
