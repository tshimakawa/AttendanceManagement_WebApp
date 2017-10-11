<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="lecture_add_comp.css" type="text/css">
<body>
<?php
session_start(); #セッション開始

mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

if($_SESSION['Term'] == "春学期" ){
	$_SESSION['Term'] = "Spring";
}
else {
	$_SESSION['Term'] = "Autumn";
}

if($_SESSION['Time'] == 1){
	$start_time = '08:50:00';
	$end_time = '10:35:00';
}elseif ($_SESSION['Time'] == 2) {
	$start_time = '10:35:00';
	$end_time = '12:20:00';
}elseif ($_SESSION['Time'] == 3) {
	$start_time = '13:00:00';
	$end_time = '14:45:00';
}elseif ($_SESSION['Time'] == 4) {
	$start_time = '14:45:00';
	$end_time = '16:30:00';
}elseif ($_SESSION['Time'] == 5) {
	$start_time = '16:30:00';
	$end_time = '18:15:00';
}else{
	$start_time = '18:15:00';
	$end_time = '20:00:00';
}

mysql_query('insert into lecture(subject,year,room,prof_id,time_id,start_time,attend_start,attend_end,end_time,weekday,term) values("'.$_SESSION['Name'].'","'.$_SESSION['Year'].'","'.$_SESSION['room_name'].'","'.$_SESSION['prof_id'].'","'.$_SESSION['Time'].'","'.$start_time.'","'.$_SESSION['attend_start'].'","'.$_SESSION['attend_end'].'","'.$end_time.'","'.$_SESSION['Weekday'].'","'.$_SESSION['Term'].'")') or die(mysql_error());

// #セッション変数を全て解除する
// $_SESSION = array();
//
// #セッションを切断するにはセッションクッキーも削除する。
// #Note: セッション情報だけでなくセッションを破壊する。
// if (isset($_COOKIE[session_name()])) {
//     setcookie(session_name(), '', time(), '/');
// }
// #最終的に、セッションを破壊する
// session_destroy();

echo '<br><br>';
echo '<div class="textbox">';
echo '<講義の追加が完了しました>'.'<br>';
echo '操作を続ける場合は'.'<br>'.'講義選択画面へ戻ってください'.'<br>';
echo '<br>';
echo '<div class="button_box">';
echo '<form action="login_attendance.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="back_button" type="submit" name="action" value="lecture">講義選択画面へ戻る</button>';
echo '</form>';
echo '<br><br>';
echo '<form action="logout.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="logout" type="submit" name="action" value="lecture">ログアウト</button>';
echo '</form>';
echo '</div>';
echo '</div>';

?>
</body>
</html>
