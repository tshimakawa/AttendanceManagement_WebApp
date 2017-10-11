<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="attendance1.css" type="text/css">
<body>
<?php

session_start();#セッション開始

#ログインしたかの確認
if($_POST['access'] != "true"){
        header("Location:login.php");
        exit;
}


if($_POST['action'] == "time" || $_POST['action'] == "student"){
	$_SESSION['Mode'] = $_POST['action'];
}
else{
	$_SESSION['date'] = $_POST['action'];
	$_SESSION['Mode'] = "student";
}

mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

$attended_empty = 0;
$exited_empty = 0;

echo '<br>';

echo '<div class="buttonbox">';

echo '<form action="login_attendance.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="back_button" type="submit" name="action" value="lecture">講義選択へ戻る</button>';
echo '</form>';
echo '<form action="logout.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="logout" type="submit" name="action" value="lecture">ログアウト</button>';
echo '</form>';
echo '<br>'.'<br>';

$date_row = mysql_query('SELECT DISTINCT date from attendance_data where lecture_id = "'.$_SESSION['lecture_id'].'"');
while($date_button = mysql_fetch_assoc($date_row)){
$hen = strtotime($date_button['date']);
#ボタン
echo '<form action="attendance1.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="individual_button" type="submit" name="action" value="'.htmlspecialchars($date_button['date']).'">'.date("n月j日",$hen).'</button>';
echo '</form>';
}
echo '<form action="attendance.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="overall_button" type="submit" name="action" value="全体">全体</button>';
echo '</form>';
echo '</div>';

echo '<br>';

#テーブルボックス
echo '<div class="tablebox">';

//$attendance = mysql_query('SELECT student.student_id, name , attendance FROM student LEFT JOIN (SELECT * FROM attendance_data where date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'") AS attendance_data ON student.student_id = attendance_data.student_id');
$attendance = mysql_query('SELECT student.student_id, name , attendance FROM (SELECT student_id,name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'") AS student LEFT JOIN (SELECT * FROM attendance_data where date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'") AS attendance_data ON student.student_id = attendance_data.student_id');
echo '<table class="noattend_table">';
echo '<caption>未出席</caption>';
		echo '<tr>';
      echo '<th class="student_id">学籍番号</th>';
      echo '<th class="name">名前</th>';
    echo '</tr>';
while($noattend = mysql_fetch_assoc($attendance)){
	if($noattend['attendance'] == NULL){
		echo '<tr>';
		echo '<td>'.$noattend['student_id'].'</td>';
		echo '<td>'.$noattend['name'].'</td>';
		echo '</tr>';
		}
}
echo '</table>';

if($_SESSION['Mode'] == "student"){
	$attended = mysql_query('SELECT attendance_data.student_id, name, attendance, time FROM attendance_data INNER JOIN (SELECT student_id,name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'") AS student ON attendance_data.student_id = student.student_id WHERE attendance_data.date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'" ORDER BY attendance_data.student_id ASC');
   echo '<table class="attended_table">';
   echo '<caption>出席済み</caption>';
   echo '<tr>';
   echo '<th class="student_id">学籍番号</th>';
   echo '<th class="name">名前</th>';
   echo '<th class="time">出席時間</th>';
   echo '<th class="time">退室時間</th>';
   echo '</tr>';
	while($data = mysql_fetch_assoc($attended)){
		if($data['attendance'] == 1){
			$exited_empty = 0;
			echo '<tr>';
      		echo '<td>'.$data['student_id'].'</td>';
			echo '<td>'.$data['name'].'</td>';
			echo '<td>'.$data['time'].'</td>';
			$attended2= mysql_query('SELECT attendance_data.student_id, name, attendance, time FROM attendance_data INNER JOIN (SELECT student_id,name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'") AS student ON attendance_data.student_id = student.student_id WHERE attendance_data.date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'"');
			while($data2 = mysql_fetch_assoc($attended2)){
				if($data2['name'] == $data['name'] && $data2['attendance'] == 0) {
					echo '<td>'.$data2['time'].'</td>';
					$exited_empty = 1;
				}
			}
			if($exited_empty == 0) {
				echo '<td>'.'</td>';
			}
			echo '</tr>';
			$attended_empty = 1;
		}
	}
}

else{
	$attended = mysql_query('SELECT attendance_data.student_id, name, attendance, time FROM attendance_data INNER JOIN (SELECT student_id,name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'") AS student ON attendance_data.student_id = student.student_id WHERE attendance_data.date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'" ORDER BY attendance_data.time ASC');
	echo '<table class="attended_table">';
	echo '<caption>出席済み</caption>';
  echo '<tr>';
  echo '<th class="student_id">学籍番号</th>';
  echo '<th class="name">名前</th>';
  echo '<th class="time">出席時間</th>';
  echo '<th class="time">退室時間</th>';
  echo '</tr>';
	while($data = mysql_fetch_assoc($attended)){
		if($data['attendance'] == 1){
			$exited_empty = 0;
			echo '<tr>';
			echo '<td>'.$data['student_id'].'</td>';
			echo '<td>'.$data['name'].'</td>';
			echo '<td>'.$data['time'].'</td>';
			$attended2= mysql_query('SELECT attendance_data.student_id, name, attendance, time FROM attendance_data INNER JOIN (SELECT student_id,name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'") AS student ON attendance_data.student_id = student.student_id WHERE attendance_data.date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'"');
			while($data2 = mysql_fetch_assoc($attended2)){
				if(($data2['student_id'] == $data['student_id']) AND ($data2['attendance'] == 0)) {
					echo '<td>'.$data2['time'].'</td>';
					$exited_empty = 1;
				}
			}
			if($exited_empty == 0) {
				echo '<td>'.'</td>';
			}
			echo '</tr>';
			$attended_empty = 1;
		}
	}
}
if($attended_empty == 0){
	echo '<tr>'.'<td>'.'</td>'.'<td>'.'</td>'.'<td>'.'</td>'.'<td>'.'</td>'.'</tr>';
}
echo '</table>';

echo '<div class="student_Mode">';
echo '<form action="attendance1.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="id_order" type="radio" name="action" value="student">学籍番号順</button>';
echo '</form>';
echo '<br>';
echo '<form action="attendance1.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="time_order" type="radio" name="action" value="time">出席時間順</button>';
echo '</form>';
echo '</div>';

echo '</div>';

?>
</body>
</html>
