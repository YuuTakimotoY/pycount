<?php
    session_start();

    date_default_timezone_set('Asia/Tokyo');

    $color = array();
    for($i = 1; $i <= 3; $i++) {
    $color[] = rand(0, 255);
    }

    if(empty($_GET['rireki'])){
        
    }else{
        if(empty($_SESSION['login'])) {
            $test_alert = "<script type='text/javascript'>alert('結果を保存するにはログインしてください');</script>";
            echo $test_alert;
            header("Location:login.php?rireki=yes");
        }else{
            $sec = $_SESSION['sec'];
            $users = $_SESSION['user'];
            $rireki_date = date('Y-m-d H:i:s');

            //DBへの接続準備
            $dsn = 'mysql:dbname=pycount;host=localhost;charset=utf8';
            $user = 'root';
            $password = 'root';
            $options = array(
                    // SQL実行失敗時に例外をスロー
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // デフォルトフェッチモードを連想配列形式に設定
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
                    // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                );

            // PDOオブジェクト生成（DBへ接続）
            $dbh = new PDO($dsn, $user, $password, $options);

            //SQL文（クエリー作成）
            $stmt = $dbh->prepare('INSERT INTO rireki (user,sec,rireki_date) VALUES (:user,:sec,:rireki_date)');

            //プレースホルダに値をセットし、SQL文を実行
            $stmt->execute(array(':user' => $users, ':sec' => $sec, ':rireki_date' => $rireki_date));

            // 接続を閉じる
            $dbh = null;

            header("Location:rireki.php");
        }
    }

  //DBへの接続準備
  $dsn = 'mysql:dbname=pycount;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $options = array(
          // SQL実行失敗時に例外をスロー
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          // デフォルトフェッチモードを連想配列形式に設定
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
          // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
          PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
      );
 
  // PDOオブジェクト生成（DBへ接続）
  $dbh = new PDO($dsn, $user, $password, $options);
 
  //SQL文（クエリー作成）
  $stmt = $dbh->prepare('SELECT * FROM rireki');
 
  //プレースホルダに値をセットし、SQL文を実行
  $stmt->execute();
 
  $result = 0;
 
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
  $array = array();
  $array2 = array();
    
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
            <h2>クリア秒数履歴</h2><br>
        <div id="rireki">
            <table align="center" border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
                <tr>
                    <th style="background:<?php echo 'rgb('.implode($color, ',').')' ?>">ユーザー</th>
                    <th style="background:<?php echo 'rgb('.implode($color, ',').')' ?>">クリア秒数</th>
                    <th style="background:<?php echo 'rgb('.implode($color, ',').')' ?>">クリア履歴登録日時</th>
                </tr>
                <?php foreach($result as $loop){ ?>
                        <tr>
                            <td><?php echo $loop['user']; ?></td>
                            <td><?php echo $loop['sec'].'秒'; ?></td>
                            <td><?php echo $loop['rireki_date'] ?></td>
                        </tr>
                    <?php }?>
            </table>
        </div>
        </div>
    </div>
    
    <!-- フッター　-->
    <footer>
    Copyright PyramidCount . All Rights Reserved.
    </footer>
</body>
</html>