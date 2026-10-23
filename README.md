# LegacyLens

**レガシー PHP の「危ない箇所」と「PHP 8 で壊れる箇所」を、1 コマンドで洗い出す診断ツール**

- SQL インジェクション・XSS など **13 ルール**で検査
- 指摘ごとの目安から **修正工数を自動で算出**
- **コードを外部に送信しない**（解析はすべて手元の PC で完結）
- フレームワークなしの **PHP 5 系のコードにもそのまま対応**

> Scan legacy PHP code for security issues and PHP 8 migration blockers — locally, with effort estimates. (UI is Japanese.)

## クイックスタート

1. [Releases](../../releases) から `legacylens-0.1.1-free.zip` をダウンロードして展開
2. 診断したいフォルダを指定して実行

```bash
# Windows
legacylens.bat scan C:\path\to\project

# macOS / Linux
./legacylens scan ./project
```

必要なのは **PHP 8.1 以上** だけです。診断する対象のコードは古い PHP でも構いません。

## 出力例

```
> legacylens scan ./sample-app
LegacyLens 0.1.1 Free — ./sample-app
4 ファイル / 55 行を検査
指摘: 高 17 / 中 3 / 低 1
修正工数の目安: セキュリティ 6.8 時間 / PHP 8 移行 5.2 時間 / 合計 12.0 時間

  MIG001  mysql_* 関数（PHP 7.0 で削除）        2 件    1.0 h
  MIG002  PHP 8 までに削除された関数            3 件    1.5 h
  MIG003  mcrypt 関数（PHP 7.2 で削除）         1 件    1.0 h
  MIG004  PHP 4 形式のコンストラクタ            1 件    0.5 h
  MIG005  非推奨の関数                          1 件    0.2 h
  MIG006  PHP 8 で構文エラー                    1 件    1.0 h
  SEC001  SQL の文字列連結                      2 件    1.0 h
  SEC002  エスケープなしの出力（XSS）           3 件    0.8 h
  SEC003  危険なコード実行・デシリアライズ      3 件    2.0 h
  SEC004  OS コマンドインジェクション           1 件    1.0 h
  SEC005  弱いパスワードハッシュ                1 件    1.0 h
  SEC006  オープンリダイレクト                  1 件    0.5 h
  SEC007  動的な include                        1 件    0.5 h

[高] MIG004  Customer.php:6
...
```

サンプルのコードは [examples/sample-app](examples/sample-app) にあります（意図的に脆弱な書き方をしたものです）。

## 検出ルール

| ID | 内容 | 重要度 |
| --- | --- | --- |
| SEC001 | SQL の文字列連結（リクエスト値が入っていれば「高」） | 高／中 |
| SEC002 | エスケープなしの出力（XSS） | 高 |
| SEC003 | eval / create_function / preg_replace の /e / リクエスト値の unserialize・extract | 高／中 |
| SEC004 | OS コマンドへのリクエスト値の受け渡し | 高 |
| SEC005 | md5 / sha1 によるパスワードハッシュ | 中 |
| SEC006 | オープンリダイレクト | 中 |
| SEC007 | リクエスト値による include / require | 高 |
| MIG001 | mysql_* 関数（PHP 7.0 で削除） | 高 |
| MIG002 | PHP 8 までに削除された関数（ereg, each, create_function など） | 高 |
| MIG003 | mcrypt 関数（PHP 7.2 で削除） | 高 |
| MIG004 | PHP 4 形式のコンストラクタ | 高 |
| MIG005 | 非推奨の関数（utf8_encode, strftime など） | 低 |
| MIG006 | PHP 8 で構文エラーになるファイル | 高 |

詳しくは [docs/rules.md](docs/rules.md) を参照してください。

## 無料版と Pro 版

| | 無料版 | Pro 版 |
| --- | :---: | :---: |
| 13 ルールすべてで検査 | ✓ | ✓ |
| 重要度別の件数・修正工数の目安 | ✓ | ✓ |
| 指摘の詳細表示 | 20 件まで | 全件 |
| HTML レポート（[サンプル](examples/sample-report.html)） | | ✓ |
| JSON 出力 | | ✓ |
| CI 連携（`--fail-on`） | | ✓ |
| アップデート | | 無料 |
| 価格 | 0 円 | 個人 2,980 円／チーム 14,800 円 |

Pro 版は BOOTH で販売しています → **https://pinz.booth.pm/items/9031011**

### Pro 版の CI 連携の例（GitHub Actions）

```yaml
- uses: shivammathur/setup-php@v2
  with:
    php-version: '8.3'
- run: php tools/legacylens.phar scan . --fail-on=high
```

## 制限事項

- リクエスト値の追跡は、関数内（同じスコープ）の代入までです。ファイルをまたぐ値の流れは追跡しません。
- 検出結果は修正の手がかりです。脆弱性がないことを保証するものではありません。

## 不具合報告・要望

[Issues](../../issues) からお願いします。**診断対象のソースコードそのものは貼らないでください。** 再現に必要な最小限のコード片だけで十分です。

## ライセンス

無料版は個人・法人・商用を問わず無料で使えます（[LICENSE.txt](LICENSE.txt)）。同梱の [nikic/php-parser](https://github.com/nikic/PHP-Parser) は BSD 3-Clause License です。
