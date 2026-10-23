# 検出ルールの詳細

## セキュリティ

### SEC001 SQL の文字列連結
`SELECT` / `INSERT` / `UPDATE` / `DELETE` などで始まる文字列に、変数を連結・埋め込みしている箇所を検出します。
- リクエスト値（`$_GET` など。同じ関数内でそれを代入した変数を含む）が入っている場合は「高」、それ以外の変数は「中」
- `(int)` キャストや `intval()` を通した値、文字列リテラルだけを代入した変数は対象外
- 対処：プレースホルダ付きのプリペアドステートメント

### SEC002 エスケープなしの出力（XSS）
`echo` / `print` / `<?=` / `printf` で、リクエスト値を `htmlspecialchars()` などに通さず出力している箇所を検出します。

### SEC003 危険なコード実行・デシリアライズ
`eval`、`create_function`、`preg_replace` の `/e` 修飾子、リクエスト値を渡した `unserialize` / `extract` / `parse_str`（第 2 引数なし）を検出します。

### SEC004 OS コマンドインジェクション
`system` / `exec` / `shell_exec` / `passthru` / `popen` / `proc_open`、バッククォートにリクエスト値を渡している箇所を検出します。

### SEC005 弱いパスワードハッシュ
`md5` / `sha1` / `crypt` に、`pass` / `pwd` を含む変数やキーを渡している箇所を検出します。対処は `password_hash()` への移行です。

### SEC006 オープンリダイレクト
`header("Location: ...")` にリクエスト値を連結している箇所を検出します。

### SEC007 動的な include
`include` / `require` のパスにリクエスト値が入っている箇所を検出します。

## PHP 8 移行

| ID | 内容 |
| --- | --- |
| MIG001 | `mysql_*` 関数（PHP 7.0 で削除） |
| MIG002 | 削除された関数：`ereg*`, `split`, `each`, `create_function`, `money_format`, `get_magic_quotes_*`, `session_register` など |
| MIG003 | `mcrypt_*` 関数（PHP 7.2 で削除） |
| MIG004 | クラス名と同名のメソッド（PHP 8 ではコンストラクタにならない）。名前空間内のクラスは対象外 |
| MIG005 | 非推奨：`utf8_encode` / `utf8_decode`（8.2）、`strftime` / `gmstrftime`（8.1）など |
| MIG006 | PHP 8 の構文として解析できないファイル（例：`$s{0}` のような文字列の波括弧添字） |

## 修正工数の目安
各指摘に 0.25〜1 時間の目安値を割り当てて合計しています。実際の工数は改修方針やテストの範囲によって変わります。
