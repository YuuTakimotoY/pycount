<?php
 
error_reporting(E_ALL); //E_STRICTレベル以外のエラーを報告する
ini_set('display_errors','On'); //画面にエラーを表示させるか
 
session_start();
 
//ログインしてなければ、login画面へ戻す
if(empty($_SESSION['login'])) header("Location:login.php");
 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PyramidCount</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?familly=Montserrat:400,700" type="text/html">
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <!-- メニュー -->
    <header width="site-width">
        <h1><a href="index.php">PyramidCount</a></h1>
        <nav id="top-nav">
        <ul>
                <li><a href="index.php">HOME</a></li>
                <?php
                    if(!empty($_SESSION['login'])){
                ?>
                    <li><a href="logout.php">ログアウト</a></li>
                <?php
                    }else{
                ?>
                    <li><a href="login.php">ログイン</a></li>
                <?php        
                    }
                ?>
                
                <li><a href="mypage.php">マイページ</a></li>
                <li><a href="register.php">登録</a></li>
                <li><a href="rireki.php">履歴</a></li>
            </ul>
        </nav>
    </header>
    <!-- メインコンテンツ -->
    <div id="main">
        <div id="count-title">
            <h1>数字合わせ</h1><br>
        
        <?php if(!empty($_SESSION['login'])){ ?>
 
         <h2>マイページ</h2>
        <section>
        <p style="margin-top:50px;"> 
            あなたの名前は<span style="font-size:20px;font-weight:bold;"><?php echo $_SESSION['user'] ;?></span>です。<br />
        </p>
        <a href="logout.php">
            <button style="margin-top:30px;" id='logout'>ログアウト</button>
        </a>
        </section>
        </div>
        <?php }else{ ?>

            <p>ログインしていないと見れません。</p>

        <?php } ?>

    </div>
    <!-- フッター　-->
    <footer>
    Copyright PyramidCount . All Rights Reserved.
    </footer>
</body>
</html>