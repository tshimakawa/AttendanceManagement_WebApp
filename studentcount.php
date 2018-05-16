<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="attendance1.css" type="text/css">
<body>
<?php

mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

$attend_student = 0;

	$attended = mysql_query('SELECT attendance_data.student_id, name, attendance, time FROM attendance_data INNER JOIN (SELECT student_id,name FROM lecture_student where lecture_id = 134) AS student ON attendance_data.student_id = student.student_id WHERE attendance_data.date = "2018-04-27" AND lecture_id = 134 ORDER BY attendance_data.time ASC');
	while($data = mysql_fetch_assoc($attended)){
		if($data['attendance'] == 1){
			$attend_student = $attend_student + 1;
		}
	}

  echo '出席者数:"'.$attend_student.'"人';

	$attendance = mysql_query('SELECT student.student_id, name , attendance FROM (SELECT student_id,name FROM lecture_student where lecture_id = 134) AS student LEFT JOIN (SELECT * FROM attendance_data where date = "2018-04-27" AND lecture_id = 134) AS attendance_data ON student.student_id = attendance_data.student_id');
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

?>
</body>
</html>
