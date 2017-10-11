<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lecture_add.js"></script>
</head>
<link rel="stylesheet" href="lecture_add.css" type="text/css">
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

if($_SESSION['lecture_add'] == 1) {
	echo <<<EOM
	<script type="text/javascript">
		alert("全ての情報を埋めてください")
	</script>
EOM;
}else {
}
?>

</br></br></br>
<div class = "lecture_box">
<form name="info_box" action="lecture_add_confirm.php" method = "post">
	<input type="hidden" name="access" value="true">
	<table class="lecture_info">
		<tr>
			<td class="table_cell">
				講義年度：
			</td>
			<td class="table_cell" align="left">
				<select name = "Year">
					<option value "explain" selected>---</option>
					<?php
					for($count = 2017; $count < 2019;$count++) {
						echo '<option value="'.$count.'">'.$count.'</option>';
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td class="table_cell">
				講義学期：
			</td>
			<td class="table_cell" align="left">
				<select name = "Term">
					<option value "explain" selected>---</option>
					<?php
					for($count = 1; $count < 3;$count++) {
						if($count == 1) {
							echo '<option value="春学期	">春学期</option>';
						}elseif($count == 2) {
							echo '<option value="秋学期	">秋学期</option>';
						}
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td class="table_cell">
				講義曜日：
			</td>
			<td class="table_cell" align="left">
				<select name = "Weekday">
					<option value "explain" selected>---</option>
					<?php
					for($count = 0; $count < 7;$count++) {
						if($count == 0) {
							echo '<option value="'.$count.'">'.日曜日.'</option>';
						}elseif($count == 1) {
							echo '<option value="'.$count.'">'.月曜日.'</option>';
						}elseif($count == 2) {
							echo '<option value="'.$count.'">'.火曜日.'</option>';
						}
						elseif($count == 3) {
							echo '<option value="'.$count.'">'.水曜日.'</option>';
						}elseif($count == 4) {
							echo '<option value="'.$count.'">'.木曜日.'</option>';
						}elseif($count == 5) {
							echo '<option value="'.$count.'">'.金曜日.'</option>';
						}elseif($count == 6) {
							echo '<option value="'.$count.'">'.土曜日.'</option>';
						}
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td class="table_cell">
				講義時限：
			</td>
			<td class="table_cell" align="left">
				<form name="time">
				<select name="Time" onchange="start_time(this)">
					<option value="explain" selected>---</option>
					<?php
					for($count = 1; $count < 7;$count++) {
						echo '<option value="'.$count.'">'.$count.'</option>';
					}
					?>
				</select>
				</form>
			</td>
		</tr>

		<tr>
			<td class="table_cell">講義教室：</td>
			<td class="table_cell" align="left">
				<select name = "room_name">
					<option value "explain" selected>---</option>
					<?php
						$room_name = mysql_query('SELECT room FROM room_beacon');
						while($room_number = mysql_fetch_assoc($room_name)){
							echo '<option value="'.$room_number['room'].'">'.$room_number['room'].'</option>';
						}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td class="table_cell">講義名：</td>
			<td class="table_cell" align="left"><input class="text" type ="text" autocomplete="off" name="Name" value=""></td>
		</tr>

		<tr>
			<td class="table_cell">出席受付開始時間：</td>
			<td class="table_cell" align="left"><input class="time_text" id="start_time" type ="time" autocomplete="off"  name="attend_start" value=""></td>
		</tr>
		<tr><td colspan="2">*注意 講義開始時間より10分以上前に設定しないでください</td></tr>

		<tr>
			<td class="table_cell">出席受付終了時間：</td>
			<td class="table_cell" align="left"><input class="time_text" type ="time" autocomplete="off"  name="attend_end" value=""></td>
		</tr>
		<tr><td colspan="2">*注意 講義終了時間より5分以上後に設定しないでください</td></tr>
	</table>
	<br>
	<button class="button" type="submit" name="registration" value = "登録">登録</button>
</form>

<br><br>

<form action="login_attendance.php" method = "post">
	<input type="hidden" name="access" value="true">
	<button class="back_button" type="submit" name="registration" value = "戻る">戻る</button>
</form>
</div>

</body>
</html>
