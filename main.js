var PassSec;   // 秒数カウント用変数
var PassageID

// 繰り返し処理の中身
function showPassage() {
   PassSec++;   // カウントアップ
   var msg = PassSec + "秒が経過しました。";   // 表示文作成
   document.getElementById("time").innerHTML = msg;   // 表示更新
}
 
// 繰り返し処理の開始
function startShowing() {
   PassSec = 0;   // カウンタのリセット
   PassageID = setInterval('showPassage()',1000);   // タイマーをセット(1000ms間隔)
}
 
// 繰り返し処理の中止
function stopShowing() {
   clearInterval( PassageID );   // タイマーのクリア
}

function countclick(num){
    //labelのDOMを習得
    var node = document.getElementById('calccount');
    var buttonnode = document.getElementById('button' + num);

    if (node.innerText !== buttonnode.innerText){
        return false;
    }

    if(buttonnode.innerText === "21"){
        stopShowing();
        localStorage.setItem('sec', PassSec);
        postForm(PassSec)
    }
    var count = parseInt(node.innerText, 10)
    node.innerText = count + 1;
    buttonnode.style.visibility = "hidden";

}

function postForm(value) {
 
    var form = document.createElement('form');
    var request = document.createElement('input');
 
    form.method = 'POST';
    form.action = 'result.php';
 
    request.type = 'hidden'; //入力フォームが表示されないように
    request.name = 'sec';
    request.value = value;
 
    form.appendChild(request);
    document.body.appendChild(form);
 
    form.submit();
}