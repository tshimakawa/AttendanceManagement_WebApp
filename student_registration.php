<?php
session_start();#セッション開始

#講義が選択されていない場合講義選択画面に遷移
if($_SESSION['lecture_id'] == null){
	header("Location:login_attendance.php");
        exit;
}
if($_SESSION['upload'] == 1) {
	echo <<<EOM
	<script type="text/javascript">
		alert("ファイルが選択されていません")
	</script>
EOM;
$_SESSION['upload'] = 0;
}elseif ($_SESSION['upload'] == 2) {
	echo <<<EOM
	<script type="text/javascript">
		alert("csvファイルを選択してください")
	</script>
EOM;
}else {
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="student_registration.js"></script>
</head>
<link rel="stylesheet" href="student_registration.css" type="text/css">
<body>
	<br /><br /><br /><br />
	<div id="upload_box">

		<form action="attendance.php" method="post">
			<input type="hidden" name="access" value="true">
			<div class="upload_cell">
				<button id="back_button" class="button" type="submit" name="action" value="">戻る</button>
			</div>
		</form>

		<br /><br />

		<form action="upload.php" method="post" enctype="multipart/form-data">
			<!-- ファイル選択用の要素（非表示にする） -->
			<input id="file_input" type="file" name="upfile" size="30" onchange="print_filename()" />
			<!-- 非表示にした要素の代わりのボタン -->
			<div class="upload_cell">
				<div class="test">
					<button id="file_select" type="button">ファイルの選択</button>
				</div>
				<div class="test">
					<!-- 選択したファイル名を表示するテキスト -->
					<input id="text" type="text" placeholder="ファイルが選択されていません" />
				</div>
			</div>
			<br /><br />
			<!-- アップロードボタン -->
			<div class="upload_cell">
				<button id="upload" type="submit" />アップロード</button>
			</div>
		</form>
		<br>＊人数が多い場合はアップロードに時間がかかります</br>
	</div>
</body>
</html>
