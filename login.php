<?php
// セッションを開始
session_start();
?>
<?php
 
error_reporting(E_ALL); //E_STRICTレベル以外のエラーを報告する
ini_set('display_errors','On'); //画面にエラーを表示させるか
 
//1.post送信されていた場合
if(!empty($_POST)){
 //本来は最初にバリデーションを行うが、今回は省略
 
  //変数にユーザー情報を代入
  $users = $_POST['user'];
  $pass = $_POST['pass'];

  /*//DBへの接続準備
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
  $dbh = new PDO($dsn, $user, $password, $options);*/
  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $db['dbname'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
  $user = $db['user'];
  $password = $db['pass'];
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
  );
  $dbh = new PDO($dsn,$user,$password,$options);
 
  //SQL文（クエリー作成）
  $stmt = $dbh->prepare('SELECT * FROM users WHERE user = :user AND pass = :pass');
 
  //プレースホルダに値をセットし、SQL文を実行
  $stmt->execute(array(':user' => $users, ':pass' => $pass));
 
  $result = 0;
 
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
  //結果が０でない場合
  if(!empty($result)){
 
    //SESSION（セッション）を使うにsession_start()を呼び出す
    session_start();
 
    //SESSION['login']に値を代入
    $_SESSION['login'] = true;
    $_SESSION['user'] = $result['user'];
    
    if(empty($_GET['rireki'])){
        //マイページへ遷移
        header("Location:mypage.php"); //headerメソッドは、このメソッドを実行する前にechoなど画面出力処理を行っているとエラーになる。
    }else{
        header("Location:rireki.php?rireki=yes");
    }
  }
}
 
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
        
        <h2>ログイン</h2>
        <div class="form">
            <form method="post">
            
                <input type="text" name="user" value="<?php if(!empty($POST['user'])) echo $POST['user']; ?>">

                <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'];?>">

                <input type="submit" value="ログイン">
                
            </form>
            <?php if(empty($_GET['rireki'])){ ?>
                <a href="register.php"><button>登録画面へ</button></a>
            <?php }else{ ?>
                <a href="register.php?rireki=yes"><button>登録画面へ</button></a>
            <?php } ?>
        </div>
        </div>
    </div>
    <!-- フッター　-->
    <footer>
    Copyright PyramidCount . All Rights Reserved.
    </footer>
</body>
</html>