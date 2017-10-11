<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>出席確認</title>
</head>
<link rel="stylesheet" href="upload.css" type="text/css">
<body>
<?php

session_start();#セッション開始

#データベースに接続
mysql_connect('localhost', 'attend_admin', 'light12345') or die(mysql_error());
mysql_select_db('attendance_platform_db') or die(mysql_error());
mysql_query('SET NAMES UTF8');

if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
  $fileType = pathinfo($_FILES["upfile"]["name"], PATHINFO_EXTENSION);
  if ($fileType == 'csv' || $fileType == 'CSV') {
    if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/" . $_FILES["upfile"]["name"])) {
      chmod("files/" . $_FILES["upfile"]["name"], 0644);

      echo '</br></br></br>';
      echo '<div class="item_table">';
        echo '<div class="cell">';
          echo "登録が完了しました";
        echo '</div>';
        echo '<br>';
        echo '<div class="cell">';
          echo '<form action="attendance.php" method="post">';
            echo '<input type="hidden" name="access" value="true">';
            echo '<button class="button" type="submit">出席確認画面へ戻る</button>';
          echo '</form>';
        echo '</div>';
        echo '<br>';

        $file = "/var/www/html/files/".$_FILES["upfile"]["name"];

        //CSVファイルを読み込みモードでオープン
        if (($fp = fopen($file, 'r')) !== FALSE){
          setlocale(LC_ALL, 'ja_JP');
          $row = 0;
          echo '<div class="cell">';
            echo '<table class="student_table">';
            //CSVファイルを1行ずつ読み込む
            while (($line = fgetcsv($fp)) !== FALSE) {
              if($row>=1){
                mb_convert_variables('UTF-8', 'sjis-win', $line);
                echo '<tr>';
                  echo '<td class="student_cell">';
                    echo $line[6];
                  echo '</td>';
                  echo '<td class="student_cell">';
                    echo $line[8];
                  echo '</td>';
                echo '</tr>';
                mysql_query('insert into lecture_student(lecture_id,student_id,name) values("'.$_SESSION['lecture_id'].'","'.$line[6].'","'.$line[8].'")') or die(mysql_error());
              }
              $row++;
            }
            echo '</table>';
          echo '</div>';
          $row=$row-1;//一行目をカウントしないため
          echo '<div class="cell">';
            echo '<br>'."上記".$row."人の受講者を登録しました";
          echo '</div>';
          $_SESSION['upload'] = 0;
        }else{
          echo '<div class="cell">';
            echo $file.'の読み込みに失敗しました。';
          echo '</div>';
        }
      echo '</div>';
    }else{
      echo "ファイルをアップロードできません。";
    }
  }else{
    $_SESSION['upload'] = 2;
  	header("Location:student_registration.php");
  	exit;
  }
}else{
  $_SESSION['upload'] = 1;
	header("Location:student_registration.php");
	exit;
}
?>
</body>
</html>
