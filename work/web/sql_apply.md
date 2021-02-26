# DB

## 集計関数

- likes の NULL を除いた個数を調べるには COUNT(likes)
- 単に全体の行数を数えたいだけなら NULL ではないことが保証されている主キーで数えてあげる(\*でも全体の行数)
  **計算**

1. SUM()
2. AVG()
3. MAX()
4. MIN()

```
  SELECT COUNT(likes) FROM posts;
  SELECT COUNT(id) FROM posts;
  SELECT COUNT(*) FROM posts;

  SELECT SUM(likes) FROM posts;
  SELECT AVG(likes) FROM posts;
  SELECT MAX(likes) FROM posts;
  SELECT MIN(likes) FROM posts;
```

## GROUP BY

- DISTINCT：このデータにどの area が含まれているか、一覧で見たい場合、area の一覧が表示される
  `SELECT DISTINCT area FROM posts;`
- この area 毎にいいね数の合計が欲しい場合
  `SELECT area, SUM(likes) FROM posts GROUP BY area;`

## HAVING で抽出条件をつける

- WHERE が GROUP BY より前に処理されるために後ろに書いては行けない
- GROUP BY した結果に条件をつけたい場合 HAVING を使ってあげる
- WHERE を使った場合 GROUP BY より前にすると 10 上を抽出した後に GROUP BY してくれる

```
SELECT
  area,
  SUM(likes)
FROM
  posts
HAVING
  SUM(likes) > 30;
//合計値が30以上を抽出している

SELECT
  area
  SUM(likes)
FROM
 posts
WHERE
 likes > 10
GROUP BY
 area;
```

## IF(),CASE を扱う

- IF

```
SELECT
  *,
  IF(likes > 10, 'a', 'b') AS team
  FROM posts;
```

- CASE

```
  SELECT
   *,
   CASE
    WHEN likes > 10 THEN 'a'
    WHEN likes > 5 THEN 'b'
    ELSE 'c'
  END AS team
  FROM posts;
```

## 抽出結果を別テーブルに

- AS はイコールのイメージ
- posts テーブルが存在する際抽出結果を別テーブルとして切り出す

```
DROP TABLE IF EXISTS posts_tokyo;
CREATE TABLE posts_tokyo AS SELECT * FROM posts WHERE area = 'TOKYO';

DROP TABLE IF EXISTS posts_copy;
CREATE TABLE posts_copy AS SELECT * FROM posts;

DROP TABLE IF EXISTS posts_skelton;
CREATE TABLE posts_skelton LIKE posts;

SHOW TABLES;
SELECT * FROM posts_tokyo;
```

## VIEW を扱ってみよう

- VIEW という仕組みを使えば元テーブルと連動する仮想的なテーブル
- VIEW 抽出条件だけを保持した仮想的なテーブルで実行するたびに、元データから再度値を抽出してくれるという仕組み

```
DROP VIEW IF EXISTS posts_tokyo_view;
CREATE VIEW posts_tokyo_view AS SELECT * FROM posts WHERE area = 'Tokyo';

UPDATE posts SET likes = 15 WHERE id = 1;
```
