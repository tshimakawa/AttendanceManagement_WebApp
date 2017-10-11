<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="login_attendance.css" type="text/css">
<body>
<?php
session_start(); #セッション開始
mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

$permission = "false";#ログインID，パスワードが正しいか
$prof_id = "";
$_SESSION['lecture_id'] = null;

if($_POST['access'] != "true" and $_SESSION['login'] != true ){#ログイン画面以外からのアクセスの場合
	header("Location:login.php");
	exit;
}

if($_POST['login'] == "ログイン"){#ログイン画面からの場合
	$prof = mysql_query('SELECT password, login_id,name FROM prof');
	while($prof_list = mysql_fetch_assoc($prof)){
		if($prof_list['password'] == $_POST['pass'] and $prof_list['login_id'] == $_POST['login_id']){
			$permission = "true";
			$_SESSION['pass'] = $_POST['pass'];$_SESSION['username'] = $prof_list['name'];$_SESSION['login_id'] = $prof_list['login_id'];
			$prof_id_list = mysql_query('SELECT prof_id from prof where login_id = "'.$_SESSION['login_id'].'" AND password = "'.$_SESSION['pass'].'"');
			while($id_list = mysql_fetch_assoc($prof_id_list)){
				$prof_id = $id_list['prof_id'];
			}
		}
	}
}
else{#講義選択ボタンからの場合
	$prof = mysql_query('SELECT password, name,login_id FROM prof');
	while($prof_list = mysql_fetch_assoc($prof)){
		if($prof_list['password'] == $_SESSION['pass'] and $prof_list['login_id'] == $_SESSION['login_id']){
			$permission = "true";
      $prof_id_list = mysql_query('SELECT prof_id from prof where login_id = "'.$_SESSION['login_id'].'" AND password = "'.$_SESSION['pass'].'"');
      while($id_list = mysql_fetch_assoc($prof_id_list)){
				$prof_id = $id_list['prof_id'];
			}
		}
	}
}

#ログインID，パスワードが間違っていた場合
if($permission != "true"){
	header("Location:login.php");
	exit;
}

#ログイン完了の証拠
$_SESSION['login'] = "true";
$_SESSION['prof_id'] = $prof_id;
$_SESSION['lecture_add'] = 0;//前回の操作時に講義情報登録でエラーが出てた場合のため

echo '<br>'.'<br>'.'<br>'.'<br>'.'<br>';

echo '<div class="buttonbox">';
#アカウント情報変更用ボタン
echo '<form action="setting.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="change_button" type="submit" name="action" value="lecture">アカウント情報の変更</button>';
echo '</form>';

#講義追加ボタン
echo '<form action="lecture_add.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="lecture_add" type="submit" name="action" value="lecture">講義の追加</button>';
echo '</form>';

#ログアウトボタン
echo '<form action="logout.php" method="post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="logout" type="submit" name="action" value="lecture">ログアウト</button>';
echo '</form>'.'</div>';

#講義一覧のプルダウン作成
echo '<div class="itembox">';
echo '<br><br><br>';
echo '<form class="lecture" action="attendance.php" method="post">';
echo '<select name = "lecture">';
echo '<option value "explain" selected>講義を選択してください</option>';
$prof_lecture = mysql_query('SELECT DISTINCT subject FROM lecture where prof_id = "'.$prof_id.'"');
while($lecture_list = mysql_fetch_assoc($prof_lecture)){
	$lecture_id_list_row = mysql_query('SELECT lecture_id from lecture where subject = "'.$lecture_list['subject'].'"');
        while($lecture_id_list = mysql_fetch_assoc($lecture_id_list_row)){
                $lecture_id = $lecture_id_list['lecture_id'];
        }
	echo '<option value="'.$lecture_id.'">'.$lecture_list['subject'].'</option>';
}
echo '</select>';
echo '<br><br>';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="button" type="submit" name="action" value="OK">選択</button>';
echo '</form>';
echo '</div>';

?>
</body>
</html>
