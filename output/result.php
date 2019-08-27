<?php
    session_start();
    $_SESSION['sec'] = $_POST['sec']; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
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
            <p>結果は<script>var sec = localStorage.getItem('sec');document.write(sec);</script>秒でした</p>
        
        <div id="count">
            結果を保存しますか？
        </div>
        <div>
            
            <a href="rireki.php?rireki=yes">
                <button type="button" id="register">履歴に登録</button>
            </a>
        </div>
        </div>
    </div>
    <!-- フッター -->
    <footer>
        Copyright PyramidCount . All Rights Reserved.
    </footer>
</body>
</html>