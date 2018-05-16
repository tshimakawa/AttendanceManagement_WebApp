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

?>
</body>
</html>
