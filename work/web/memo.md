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
