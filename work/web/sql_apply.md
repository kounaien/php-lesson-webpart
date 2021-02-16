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
