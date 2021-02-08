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

## DB

**用語**

- table : 一つ一つの表のこと
- record : 行
- colomn : 列
- SQL(structured query language)
- SQL ではコードはクエリ（問い合わせをする）と呼ばれる
- SQL があらかじめ用意している命令は大文字、自分でつけるテーブル名やカラム名などは小文字にすることが多い。

**テーブル作成　カラム名作成**

- CREATE TABLE posts (); //posts はテーブル名
- 引数にはカラム名を入れる同時に入れる型も入れる

```
CRAETE TABLE posts (
  message VARCHAR(140), likes INT
);

//character varying : 可変長の文字列

SHOW TABLES;
```

**レコードの作成**

```
INSERT INTO
 posts (message, likes)
 VALUES
  ('hello', 22);
```

**テーブルの削除**

```
DROP TABLE IF EXISTS posts;
```

**データ型**

1. 整数

- ITNYINT : -128 ~ 127
- INT : -21 億 ~ 21 億
- BIGINT : -922 京 ~ 922 京
- TINYINT UNSIGNED : 0 ~ 255
- INT UNSIGNED : 0 ~ 42 億
- BIGINT UNSIGNED : 0 ~ 1844 京

2. 実数
   - DECIMAL : 固定小数点 (全体, 小数点以下)を引数してい
   - FLOAT : 浮動小数点
   - DOUBLE : 浮動小数点（高精度）
3. 文字列　（）引数で文字数を指定
   - CHAR : ~ 255 字
   - VARCHAR : ~ 65535 文字
   - TEXT : それ以上
   - ENUM : 特定の文字列から１つ
   - SET : 特定の文字列から複数
4. 真偽値
   - BOOL : TRUE / FALSE > TINYINT(1) : 1 / 0
5. 日時
   - DATE : 日付
   - TIME : 時間
   - DATETIME : 日時

**ENUM, SET**

- ENUM
  - 例：posts(category ENUM('Gadget', 'Game', 'Business'));でカラム作成、インサート時：posts(category) VALUES ('Gadget')で１つ選ぶ。
  - またインデックス番号で指定しても可能
- SET
  - 複数の値を選べる。
  - 文字列で囲った中に複数入れる。空白入れはいけない
  - 数値で表現可能値を数値で管理しているため。左から 2^0 //1, 2^1 //2, 2^2 //4。なので'Gadget' を選ぶには 1、'Gadget,Game'のさいは 1+2 で 3 を指定。
  ```
    INSERT INTO posts (category) VALUES ('Gadhet,Game,Bushiness');
    SELECT * FROM posts; //Gadget,Game,Bushiness
  ```

**真偽値や日時**

- 真偽値は TRUE は１で FALSE は０で管理
- 日時は時間を省略すると０時０分０秒になる、また現在の日時を表す NOW()関数が使え、従来の表現はハイフンやコロンで表現

**NULL の扱い**

- 何も値がないよという*NULL という値*が入る
  - テーブルに message, likes ２つのカラムがある場合 INSERT する際 message しか渡さないと NULL が入る
  - NOT NULL という NULL を受け付けないという制約もつけることができる。

```
  INSERT INTO posts (message) VALUES ('haro') //likes > NULLが入る自動的に

  CREATE TABLE posts (
    message VARCHAR(140),
     likes NOT NULL
    )
```

**デフォルト値の設定**

- 値がなにもない時 NULL の場合などなくて困る時は値を事前にセットできる

```
  CREATE TABLE posts (
    message VARCHAR(140),
    likes INT DEFAULT 0 //何もインサートしなくてもデフォルト値が入る
  )
```

**\*値の制限**

- 値の制限と重複を防いでいる

```
  likes INT CHECK(likes >= 0 AND likes <= 100),
  message VARCHAR(140) UNIQUE
```
