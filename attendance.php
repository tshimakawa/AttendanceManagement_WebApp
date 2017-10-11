<?php
session_start(); #セッション開始
if ( $_POST['mode'] == 'download' ) {

	#データベースに接続
	mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
	mysql_select_db('attendance_platform_db') or die(mysql_error());
	mysql_query('SET NAMES UTF8');

    $contents = "学籍番号".','."氏名";
    $csv_date_row = mysql_query('SELECT DISTINCT date from attendance_data where lecture_id = "'.$_SESSION['lecture_id'].'"');
    while($csv_date_button = mysql_fetch_assoc($csv_date_row)){
		$csv_hen = strtotime($csv_date_button['date']);
		$contents = $contents.','.date("n月j日",$csv_hen);
	}
	$contents = $contents.','."合計"."\n";

	$csv_student = mysql_query('SELECT student_id, name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'"');
	while($csv_student_list = mysql_fetch_assoc($csv_student)){
		$csv_count = 0;
		$contents = $contents. $csv_student_list['student_id'].','.$csv_student_list['name'];
		$csv_date = mysql_query('SELECT DISTINCT date from attendance_data where lecture_id = "'.$_SESSION['lecture_id'].'"');
		$csv_date_row = mysql_num_rows($csv_date);
		while($csv_date_button = mysql_fetch_assoc($csv_date)){
			$csv_attendance = mysql_query('SELECT * FROM attendance_data WHERE student_id = "'.$csv_student_list['student_id'].'" AND date = "'.$csv_date_button['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'" AND attendance = 1');
			$csv_result_rows = mysql_num_rows($csv_attendance);
			if($csv_result_rows == 0){
				$contents=$contents.','."×";
			}
			else{
				while($csv_attendance_data = mysql_fetch_assoc($csv_attendance)){
					$contents=$contents.','."○";
					$csv_count++;
				}
			}
		}
		$contents=$contents.','."'$csv_count"."/".$csv_date_row."\n";
	}

	//文字化けを防ぐ
	$contents = mb_convert_encoding ( $contents , "sjis-win" , 'utf-8' );
  //出力ファイル名の作成
  $csv_file = $_SESSION['lectureName'] ."_出席情報".'.csv';
	//MIMEタイプの設定
   header("Content-Type: application/octet-stream");
  	//名前を付けて保存のダイアログボックスのファイル名の初期値
   header("Content-Disposition: attachment; filename={$csv_file}");
   // データの出力
   echo($contents);
   exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="attendance.css" type="text/css">
<body>
<?php

#ログインしたかの確認
if($_SESSION['access'] != "true" && $_POST['access'] != "true"){
	header("Location:login.php");
  exit;
}

#データベースに接続
mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

$attended_empty = 0;
$exited_empty = 0;

#選択した講義の講義idを保存
if($_POST['lecture'] != null){
	$_SESSION['lecture_id'] = $_POST['lecture'];
}

#講義が選択されていない場合講義選択画面に遷移
if($_SESSION['lecture_id'] == null){
	header("Location:login_attendance.php");
  exit;
}

#講義名取得
$lecturename = mysql_query('SELECT subject from lecture where lecture_id = "'.$_SESSION['lecture_id'].'"');
while($lecture_name = mysql_fetch_assoc($lecturename)){
	$_SESSION['lectureName'] = $lecture_name['subject'];
}

echo '<br>'.'<br>'.'<br>';
echo '<div class="buttonbox">';
echo '<form action="login_attendance.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="back_button" type="submit" name="action" value="lecture">講義選択に戻る</button>';
echo '</form>';
echo '<form action="" method="post">';
echo '<input type="hidden" name="mode" value="download">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="csv_download" type="submit" name="action" value="">CSVダウンロード</button>';
echo '</form>';
echo '<form action="student_registration.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="student_registration" type="submit" name="action" value="lecture">学生の登録</button>';
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
echo '<table class="all_date">';
echo '<caption>出席一覧</caption>';
echo '<tr>';
echo '<th class="student_id">学籍番号</th>'.'<th class="name">名前</th>';
$date_row = mysql_query('SELECT DISTINCT date from attendance_data where lecture_id = "'.$_SESSION['lecture_id'].'"');
while($date_button = mysql_fetch_assoc($date_row)){
	$hen = strtotime($date_button['date']);
        echo '<th class="date">'.date("n月j日",$hen).'</th>';
        }
	echo '<th class="total">合計</th>';
echo '</tr>';

$student = mysql_query('SELECT student_id, name FROM lecture_student where lecture_id = "'.$_SESSION['lecture_id'].'"');

while($student_list = mysql_fetch_assoc($student)){
	$count = 0;
	echo '<tr>';
	echo '<td>'.$student_list['student_id'].'</td>';
	echo '<td>'.$student_list['name'].'</td>';
	$date = mysql_query('SELECT DISTINCT date from attendance_data where lecture_id = "'.$_SESSION['lecture_id'].'"');
	$date_row = mysql_num_rows($date);
	while($date_button = mysql_fetch_assoc($date)){
		$attendance = mysql_query('SELECT * FROM attendance_data WHERE student_id = "'.$student_list['student_id'].'" AND date = "'.$date_button['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'" AND attendance = 1');
		//$attendance2 = mysql_query('SELECT student.student_id, name , attendance FROM student LEFT JOIN (SELECT * FROM attendance_data where date = "'.$_SESSION['date'].'" AND lecture_id = "'.$_SESSION['lecture_id'].'") AS attendance_data ON student.student_id = attendance_data.student_id');
		$result_rows = mysql_num_rows($attendance);
		if($result_rows == 0){
			echo '<td style="color:#fff" bgcolor="#ff0000">×</td>';
			}
		else{
			while($attendance_data = mysql_fetch_assoc($attendance)){
				echo '<td bgcolor="#00ffff">○</td>';
				$count++;
				}
			}
		}
	echo '<td>'.$count."/".$date_row.'</td>';
	echo '</tr>';
}
echo '</table>';
echo '</div>';
?>
</body>
</html>
