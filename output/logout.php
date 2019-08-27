<?php
// セッションを開始
session_start();
// セッションを破棄
$_SESSION = array();
session_destroy();

$test_alert = "<script type='text/javascript'>alert('ログアウトしました。');</script>";
echo $test_alert;

header( "Location: index.php" ) ;
?>
