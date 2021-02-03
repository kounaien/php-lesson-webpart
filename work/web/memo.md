# ウェブ開発編

## htmlspecialchars

---

- 単なる文字として値を出力したい場合
- $name = 'taro <script>alert(1);</script>'
- これを html 内で展開すると JS が起動するそうさせないように
- htmlspecialchars($name, ENT_QUOTTES, 'UTF-8');

## 関数を別ファイルに

---

- 直接ブラウザからアクセスできないように WEB フォルダ以外の場所に配置
- 関数を他のページでも使えるよにするので別フィアイルに元ファイルに require で呼び出し関数実行

## 別の構文

---

- ブロックをコロンに置き換えることができる
- 終わりに endif,endforeach,endfor,endwhile, endswitch で締める

## フォーム

---

- form の送信先は form タグの action 属性で指定
- 送信形式は method 属性,GET,POST 指定可能
- 送信先でその値をどの名前で受け取ればいいか name 属性で決める
- trim();空白を取り除く
- nl2br();改行のまま
- impload(',' , $);カンマ区切りで連結した文字列を表示
- form の select 属性で multiple 選択すると name 属性に[]をたさないと配列認識されない
- FILTER_REQUIRE_ARRAY
- isset();, empty();
- NULL 合体演算子とは論理演算子の一種左辺が null または undefined の場合に右の値を返し、それ以外の場合には左の値を返す

## cookie

- ブラウザ側に保存、サイズ制限あり、文字列のみ、安全性が低い（ディベロッパーツールで編集、削除が行えるため）、簡単な設定項目など
- setcookie();これ以前のコードには何も出力してはいけない。filter_input(INPUT_COOKIE, 'color');で受け取る
- expoire は有効期限で session はブラウザを閉じるまで、オプションで色々指定可能
- setcookie('color','');空文字にすると PHP が内部的に Cookie の有効期限を過去日時にセットしてくれて Cookie が削除されるという仕組み
  **ページのリダイレクト**
- header('Location: http://localhost:8080/index.php');
- まず setcookie();同様この命令の前に何らかの出力はしてはいけない、L は大文字、コロンのあとは半角スペース、絶対パス

## session

- サーバー側に保存、サイズ制限ない、オブジェクトなども OK、安全性が高い、認証情報など
- session_start();とすると$_SESSIONという特殊な変数が使えるので、$\_SESSION['color']その color に対して GET で渡ってきた color を代入
- unset($\_SESSION['color']);で消去

## GET と POST の違い

**GET**

- 情報の取得
- URL に値が含まれる
- 安全性が低い
- サイズや種類に制限あり

**POST**

- 情報の追加、更新、削除
- 安全性がやや高い
- URL に値が含まれないが工夫すればブラウザから見れる
- サイズや種類に制限ない

## POST 直接のアクセスを防ぐ

- POST されたかどうかは$\_SERVER という特殊な変数
- その変数の REQUEST_METHOD が POST だったらという条件分岐をしてあげる
- それ以外は exit('Invalid Request');でメッセージも設定

## 二重投稿の阻止

- result.php の方で処理を行うとリロードするともう一度処理が行えてしまう
- なので form を送信するページで送信の処理を行い header();関数で result.php の方に飛ばしてしまえばリロードしても送信の処理は行われない。
- header 関数はこのスクリプトが終了したあとに実行されるためこれ以降の命令を実行させずにリダイレクトするには、ここで、exit()として上げる必要がある

## CSRF(cross site request forgery)

- 別のサイトからリクエストが偽造されてくる
  **トークン**
- 代表的な対処
- ここでフォームを生成するときに推測が難しいトークンと呼ばれる文字列を作ってあげて、まずは Session を使ってサーバーに保存
- また index.php のフォームにもこの値を埋め込んでおくその上でここでフォームが送信されるときに、このトークンを一緒に送信してあげて、サーバー側で処理をする際にここで送られてきたトークンと Session で保存されていたトークンが一致した場合のみ投稿処理を行う

  **トークンを作る処理**

- function createToken() {
  if (!isset($\_SESSION['token'])) {
  $\_SESSION['token'] = bin2hex(random_bytes(32));
  }
  }
- random_bytes();ランダムな文字列を生成、引数にバイト単位で長さを指定
- ただこのままだとバイナリの文字列なので、bin2hex という関数で、16 進数の文字列に戻す

**トークンのチェックする関数**

```
function validateToken()
{
  if(
    empty($_SESSION['token']) ||
    $_SESSION['token'] !== filter_input(INPUT_POST, 'token'){
      exit('Invalid Request);
    }
  )

session_start();
```

**トークンの仕込み方**

```
//先頭
createToken();

//処理する中に
validateToken();

<form action='index.php' method='post'>
  <input type='hidden' name='token'
  value="<?= h($_SESSION['token']) ?>">
  <button>send</button>
</form>
```
