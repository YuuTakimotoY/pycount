<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　商品詳細ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
$partnerUserId = '';
$partnerUserInfo = '';
$myUserInfo = '';
$productInfo = '';

// 画面表示用データ取得
//================================
// 商品IDのGETパラメータを取得
$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
// DBから商品データを取得
$viewData = getProductOne($p_id);
// DBから掲示板とメッセージデータを取得
$viewData2 = getMsgsAndBord($p_id);
//パラメータに不正な値が入っているのかチェック
if(empty($viewData)){
    error_log('エラー発生:指定ページに不正な値が入りました');
    header("Location:index.php"); //トップページへ
}
/*if(empty($viewData2)){
    error_log('エラー発生:指定ページに不正な値が入りました');
    header("Location:mypage.php"); //マイページへ
}*/
debug('取得したDBデータ：'.print_r($viewData,true));
debug('取得したDBデータ2：'.print_r($viewData2,true));


// 商品情報を取得
$productInfo = getProductOne($viewData['id']);
debug('取得したDBデータ：'.print_r($productInfo,true));
// 商品情報が入っているかチェック
if(empty($productInfo)){
  error_log('エラー発生:商品情報が取得できませんでした');
  header("Location:mypage.php"); //マイページへ
}
// DBから自分のユーザー情報を取得
$myUserInfo = getUser($_SESSION['user_id']);
debug('取得したユーザデータ：'.print_r($partnerUserInfo,true));
// DBから自分のボードIDを取得
$mybordId = getBordId($p_id);
// 自分のユーザー情報が取れたかチェック
if(empty($myUserInfo)){
  error_log('エラー発生:自分のユーザー情報が取得できませんでした');
  header("Location:mypage.php"); //マイページへ
}

// post送信されていた場合
if(!empty($_POST)){
  debug('POST送信があります。');
  
  //ログイン認証
  require('auth.php');
  
  //バリデーションチェック
  $msg = (isset($_POST['msg'])) ? $_POST['msg'] : '';
  //最大文字数チェック
  validMaxLen($msg, 'msg', 500);
  //未入力チェック
  validRequired($msg, 'msg');
  
  if(empty($err_msg)){
    debug('バリデーションOKです。');

    //例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      $sql = 'INSERT INTO message (bord_id, send_date, from_user, msg, create_date) VALUES (:b_id, :send_date, :from_user, :msg, :date)';
      $data = array(':b_id' => $mybordId['id'], ':send_date' => date('Y-m-d H:i:s'), ':from_user' => $_SESSION['user_id'], ':msg' => $msg, ':date' => date('Y-m-d H:i:s'));
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);

      // クエリ成功の場合
      if($stmt){
        $_POST = array(); //postをクリア
        $_SESSION['msg_success'] = 'メッセージを送信しました。';
        debug('商品詳細画面へ遷移します。');
        header("Location: " . $_SERVER['PHP_SELF'] .'?p_id='.$p_id); //自分自身に遷移する
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<?php
$siteTitle = '商品詳細';
require('head.php');
?>

    <body class="page-productDetail page-1colum">
        
    <!-- ヘッダー -->
    <?php
        require('header.php');
    ?>
    <p id="js-show-msg" style="display:none;" class="msg-slide">
      <?php echo getSessionFlash('msg_success'); ?>
    </p>
    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
        <!-- Main -->
        <section id="main">

            <div class="title">
                <span class="badge"><?php echo sanitize($viewData['category']); ?></span>
                <?php echo sanitize($viewData['name']); ?>
                <i class="fa fa-heart icn-like js-click-like <?php if(isLike($_SESSION['user_id'], $viewData['id'])){ echo 'active'; } ?>" aria-hidden="true" data-productid="<?php echo sanitize($viewData['id']); ?>" ></i>
            </div>
            <div class="product-img-container">
                <div class="img-main">
                    <img src="<?php echo showImg(sanitize($viewData['pic'])); ?>" alt="メイン画像：<?php echo sanitize($viewData['name']); ?>" id="js-switch-img-main">
                </div>
                <div class="img-sub">
                    <img src="<?php echo showImg(sanitize($viewData['pic'])); ?>" alt="画像1：<?php echo sanitize($viewData['name']); ?>" class="js-switch-img-sub">
                    <img src="<?php echo showImg(null); ?>" alt="画像2：<?php echo sanitize($viewData['name']); ?>" class="js-switch-img-sub">
                </div>
            </div>
            <h2 class="title" style="margin-bottom:15px;border-left: 6px solid #fe8a8b;">レビュー本詳細</h2>
            <div class="product-detail">
                <p><?php echo sanitize($viewData['comment']); ?></p>
            </div>
            <h2 class="title" style="margin-bottom:15px;border-left: 6px solid #fe8a8b;">レビュー本掲示板</h2>
            <div class="area-bord" id="js-scroll-bottom">
                <?php
                    if(!empty($viewData2)){
                        foreach($viewData2 as $key => $val){
                            if(!empty($val['from_user']) && $val['from_user'] !== $_SESSION['user_id']){
                ?>
                                <div class="msg-cnt msg-left">
                                <div class="avatar">
                                    <img src="<?php echo sanitize(showImg($partnerUserInfo['pic'])); ?>" alt="" class="avatar">
                                    <?php $val['u_name'] ?>
                                </div>
                                <p class="msg-inrTxt">
                                    <span class="triangle"></span>
                                    <?php echo sanitize($val['msg']); ?>
                                </p>
                                <div style="font-size:.5em;"><?php echo sanitize($val['send_date']); ?></div>
                                </div>
                <?php
                            }else{
                ?>
                                <div class="msg-cnt msg-right">
                                <div class="avatar">
                                    <img src="<?php echo sanitize(showImg($myUserInfo['pic'])); ?>" alt="" class="avatar">
                                </div>
                                <p class="msg-inrTxt">
                                    <span class="triangle"></span>
                                    <?php echo sanitize($val['msg']); ?>
                                </p>
                                <div style="font-size:.5em;text-align:right;"><?php echo sanitize($val['send_date']); ?></div>
                                </div>
                <?php
                            }
                        }
                    }else{
                ?>
                    <p style="text-align:center;line-height:20;">メッセージ投稿はまだありません</p>
            <?php
                }
            ?>
            
            </div>
            <div class="area-send-msg">
                <form action="" method="post">
                    <textarea name="msg" cols="30" rows="3"></textarea>
                    <input type="submit" value="送信" class="btn btn-send">
                </form>
            </div>
            <div class="product-buy">
                <div class="item-left">
                    <a href="index.php<?php echo appendGetParam(array('p_id')); ?>">&lt; 商品一覧に戻る</a>
                </div>
            </div>
        </section>
        </div>

        <!-- footer -->
        <?php
        require('footer.php'); 
        ?>