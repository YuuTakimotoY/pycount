<?php
// セッションを開始
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>PyramidCount</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?familly=Montserrat:400,700" type="text/html">
    <link rel='stylesheet' type='text/css'  href='main.css'>
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
        <div class="count-title">
            <h1>数字合わせ</h1><br>
            <p id="time">0秒経過しました。</p>
            <p style="font-size:20px">この数字を探してね<br></p>
            <p style="font-size:40px" id="calccount">1</p>
            <?php
             $array_button = Array();
             for($i=0;$i<21;$i++){array_push($array_button, $i+1);}
             if(shuffle($array_button)){
            ?>
            <div class="button-size">
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>" type="button" id="button1" onclick="countclick(1)"><?php echo $array_button[0] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>" type="button" id="button2" onclick="countclick(2)"><?php echo $array_button[1] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>" type="button" id="button3" onclick="countclick(3)"><?php echo $array_button[2] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button4" onclick="countclick(4)"><?php echo $array_button[3] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button5" onclick="countclick(5)"><?php echo $array_button[4] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button6" onclick="countclick(6)"><?php echo $array_button[5] ?></button>
            </div>
            <div class="button-size">
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button7" onclick="countclick(7)"><?php echo $array_button[6] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button8" onclick="countclick(8)"><?php echo $array_button[7] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button9" onclick="countclick(9)"><?php echo $array_button[8] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button10" onclick="countclick(10)"><?php echo $array_button[9] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button11" onclick="countclick(11)"><?php echo $array_button[10] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button12" onclick="countclick(12)"><?php echo $array_button[11] ?></button>
            </div>
            <div class="button-size">
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button13" onclick="countclick(13)"><?php echo $array_button[12] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button14" onclick="countclick(14)"><?php echo $array_button[13] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button15" onclick="countclick(15)"><?php echo $array_button[14] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button16" onclick="countclick(16)"><?php echo $array_button[15] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button17" onclick="countclick(17)"><?php echo $array_button[16] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button18" onclick="countclick(18)"><?php echo $array_button[17] ?></button>
            </div>
            <div class="button-size">
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button19" onclick="countclick(19)"><?php echo $array_button[18] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button20" onclick="countclick(20)"><?php echo $array_button[19] ?></button>
                <button style="background:<?php echo sprintf('#%06x',rand(0x000000, 0xFFFFFF))?>"  type="button" id="button21" onclick="countclick(21)"><?php echo $array_button[20] ?></button>
            </div>
            
            
            <?php }else{} ?> 
        </div>
    </div>
    <!-- フッター -->
    <footer>
    Copyright PyramidCount . All Rights Reserved.
    </footer>

    <script>
        startShowing();
    </script>
</body>
</html>