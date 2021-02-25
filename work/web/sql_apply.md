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
