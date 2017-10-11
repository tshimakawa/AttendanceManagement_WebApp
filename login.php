<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="login.css" type="text/css">
<body>
<?php
echo '<br>'.'<br>'.'<br>'.'<br>'.'<br>'.'<br>';
echo '<div class="login_box">';
echo '<form action="login_attendance.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo "ユーザーID".'<br>';
echo '<input class="text" type ="text" autocomplete="off" name="login_id" value="">'.'<br>';
echo '<br>';
echo "パスワード".'<br>';
echo '<input class="text" type ="password" autocomplete="off"  name="pass" value="">'.'<br>';
echo '<br>';
echo '<button class="login_button" type="submit" name="login" value = "ログイン">ログイン</button>';
echo '</form>';
echo '<br>';
echo '<form action="prof_add.php" method = "post">';
echo '<input type="hidden" name="access" value="true">';
echo '<button class="prof_add_button" type="submit" name="login" value = "ログイン">アカウント追加</button>';
echo '</form>';
echo '</div>';

?>
</body>
</html>
