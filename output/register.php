<?php
// セッションを開始
session_start();
?>
<?php
date_default_timezone_set('Asia/Tokyo');
error_reporting(E_ALL); //E_STRICTレベル以外のエラーを報告する
ini_set('display_errors','On'); //画面にエラーを表示させるか
 
//1.post送信されていた場合
if(!empty($_POST)){
 
  //エラーメッセージを定数に設定
  define('MSG01','入力必須です');
  define('MSG02', 'Emailの形式で入力してください');
  define('MSG03','パスワード（再入力）が合っていません');
  define('MSG04','半角英数字のみご利用いただけます');
  define('MSG05','6文字以上で入力してください');
 
  //配列$err_msgを用意
  $err_msg = array();
 
  //2.フォームが入力されていない場合
  if(empty($_POST['user'])){
 
    $err_msg['user'] = MSG01;
 
  }
  if(empty($_POST['pass'])){
 
    $err_msg['pass'] = MSG01;
 
  }
  if(empty($_POST['pass_retype'])){
 
    $err_msg['pass_retype'] = MSG01;
 
  }
 
  if(empty($err_msg)){
 
    //変数にユーザー情報を代入
    $users = $_POST['user'];
    $pass = $_POST['pass'];
    $pass_re = $_POST['pass_retype'];
 
    //4.パスワードとパスワード再入力が合っていない場合
    if($pass !== $pass_re){
      $err_msg['pass'] = MSG03;
    }
 
    if(empty($err_msg)){
 
      //5.パスワードとパスワード再入力が半角英数字でない場合
      if(!preg_match("/^[a-zA-Z0-9]+$/", $pass)){
        $err_msg['pass'] = MSG04;
 
      }elseif(mb_strlen($pass) < 6){
      //6.パスワードとパスワード再入力が6文字以上でない場合
 
        $err_msg['pass'] = MSG05;
      }
 
      if(empty($err_msg)){
 
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
        $stmt = $dbh->prepare('INSERT INTO users (user,pass,login_time) VALUES (:user,:pass,:login_time)');
 
        //プレースホルダに値をセットし、SQL文を実行
        $stmt->execute(array(':user' => $users, ':pass' => $pass, ':login_time' => date('Y-m-d H:i:s')));
        
        //SESSION（セッション）を使うにsession_start()を呼び出す
        session_start();
    
        //SESSION['login']に値を代入
        $_SESSION['login'] = true;
        $_SESSION['user'] = $users;
        if(!empty($_GET['rireki'])){
            header("Location:rireki.php?rireki=yes"); //マイページへ
        }else{
            header("Location:mypage.php"); //マイページへ
        }
        
      }
 
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
          <h2>ユーザー登録</h2>
          <div class="form">
            <form method="post">
              <span class="err_msg"><?php if(!empty($err_msg['user'])) echo $err_msg['user']; ?></span>
              <input type="text" name="user" placeholder="ユーザー名" value="<?php if(!empty($_POST['user'])) echo $_POST['user'];?>">
      
              <span class="err_msg"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass']; ?></span>
              <input type="password" name="pass" placeholder="パスワード" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'];?>">
      
              <span class="err_msg"><?php if(!empty($err_msg['pass_retype'])) echo $err_msg['pass_retype']; ?></span>
              <input type="password" name="pass_retype" placeholder="パスワード（再入力）" value="<?php if(!empty($_POST['pass_retype'])) echo $_POST['pass_retype'];?>">
              <input type="submit" value="登録">
            </form>
          </div>
      </div>   
    </div>
    <!-- フッター　-->
    <footer>
    Copyright PyramidCount . All Rights Reserved.
    </footer>

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="main.js"></script>

</body>
</html>