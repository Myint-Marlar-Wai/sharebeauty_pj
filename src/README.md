# ONCE EC PROJECT

## ディレクトリ

### /mock : デザイン&フロント作業用

- /mock/images : 画像、アイコン系
- /mock/css : コンパイル後のCSS
- /mock/sass : sassファイル
- /mock/js : jsファイル
- /mock/views : viewファイル（ディレクトリ構造は特に指定なし）

※ /mockで作業したものを
バックエンド側で/resources配下にコピーし、viewの動的ページ化を行う（html->blade.php化）

## 初期設定

### Nodeパッケージインストール

- `npm install`

### PHPパッケージインストール

- `composer install`

### CSS/JSのコンパイル

webpack.mix.js参照

#### 実行例

- 開発環境向け アセットの変更を監視しながらMixタスクを実行  `npm run watch -appsystem=shop`
- 開発環境向け Mixタスクを実行  `npm run dev -appsystem=shop`
- 本番環境向け Mixタスクを実行し、出力を圧縮 `npm run prod -appsystem=shop`

#### appsystem 引数

- 引数一覧
    - `-appsystem=shop` ショップ（ユーザー側、買い手側）
    - `-appsystem=seller` ショップ運営（利用者側、売り手側）
    - `-appsystem=admin` 管理（会社）
    - `-appsystem=batch` バッチ処理

### PHPコード品質ツールインストール

- `./cmd-php-fixer.sh install`
- IDEの設定
    - php-cs-fixerのパスを `tools/php-cs-fixer/vendor/bin/php-cs-fixer`に設定
    - php-cs-fixerのインスペクションを有効にする
    - php-cs-fixerのルールセットのパスを `.php-cs-fixer.dist.php`に設定

### IDE補完用情報の生成

- `./cmd-ide-helper.sh base`
- `./cmd-ide-helper.sh models`
    - Eloquentモデルのphpdocを生成するため、DBの設定が完了している必要があります。

### ビルトインサーバーで起動

- `php artisan serve`

## 環境変数

.env ファイルもしくは、サーバー環境変数に設定します。

### APP_SYSTEM

- `shop` ショップ（ユーザー側、買い手側）
- `seller` ショップ運営（利用者側、売り手側）
- `admin` 管理（会社）
- `batch` バッチ処理

### APP_DATA_ENV

- `production` 本番データ
- `development` 開発データ

## .envファイル（環境変数）の運用方法とルール

.env.<APP_ENV> 毎のファイルを準備すると、ファイル数が多くなり、記述も重複していくため、別の箇所で各環境ごとの値を記述し、本体ファイルは自動生成する仕組みを取る。

生成元となる内容を[envs/](./envs/)ディレクトリで用意し、[cmd-envs.sh](./cmd-envs.sh) コマンドでLaravelディレクトリへ合成・配置します。


### .env生成方法

1. [envs/](./envs/) ディレクトリを開く。
2. [envs/.env.base](./envs/.env.base) に、.envの共通項目を記述する。
3. [envs/.env.shop-development](./envs/.env.shop-development) や [envs/.env.seller-development](./envs/.env.seller-development) 等の `envs/.env.XXXX` に、.envの差分（上書き）項目を記述する。
4. [envs/map-default.json](./envs/map-default.json) に、どのファイルをどの順番で上書きして生成するかをjsonで記述する。
   - キーが環境名で、値の配列が使用するファイルの一覧で、先頭がベースとなり、後ろのファイルで順番に上書きされる。
   - 例
     ```json
     {
         "shop-development": [
           ".env.base",
           ".env.shop-development"
         ],
         "seller-development": [
           ".env.base",
           ".env.seller-development"
         ]
     }
     ```
5. [Laravelルート](./) ディレクトリへ戻る。
6. [cmd-envs.sh](./cmd-envs.sh) コマンドを`./cmd-envs.sh update envs/map-default.json` のように実行する。
   - Laravelルートディレクトリに .env ファイル群 が生成されます。既存ファイルは上書きされます。
   - `envs/map-default.json` は変更可能です。

### ローカル用の.env生成方法 (任意)

基本の方法は、前述の「.env生成方法」を参照ください。追加操作のみ説明します。

1. [envs/.env.example-local-development](./envs/.env.example-local-development) を [envs/.env.local-development](./envs/.env.local-development) にコピーします。
   - ローカル用の機密情報等の記述をします
   - `.env.local-*`ファイルはgitignoreされています。
2. [envs/.env.example-testing-local-development](./envs/.env.example-testing-local-development) を [envs/.env.testing-local-development](./envs/.env.testing-local-development) にコピーします。
    - テスト分の差分を記述します
   - `.env.testing-local-*`ファイルはgitignoreされています。
3. [envs/map-example-local.json](./envs/map-example-local.json) を [envs/map-local.json](./envs/map-local.json) に、コピーします。
    - .envファイル群 が生成されます。既存ファイルは上書きされます。
    - `map-local-*.json`ファイルはgitignoreされています。
    - 例
    ```json
    {
        "local-development" : [
            ".env.base",
            ".env.local-development"
        ],
        "testing-local-development" : [
            ".env.base",
            ".env.local-development",
            ".env.testing",
            ".env.testing-local-development"
        ]
    }

    ```
4. [cmd-envs.sh](./cmd-envs.sh) コマンドを`./cmd-envs.sh update envs/map-local.json` のように実行する。


## テスト

### 準備

- ` .env.testing-<APP_ENV> ` の名前でテスト用のenvファイルを用意します。
  - ※<APP_ENV>は通常時の環境名です。
  - テスト用envファイルには、テスト用の値を設定してください。
    - (テストアカウント設定だったり、DBを変えたり、今はまだないのでこれから追記していくことになる...)
  - ローカルDockerコンテナで、docker-composeでのサーバーの環境変数として、設定されている値は、`.env.testing-<APP_ENV>` では上書きできないので注意です。(※このパターンが発生した場合、仕組みを調整する必要ありです。)

### コマンドの説明

[cmd-test.sh](./cmd-test.sh) を使用します。

このコマンドは、内部で`APP_ENV`を上書きして、phpunitを実行します。

第１引数がtestの場合は、`testing-<APP_ENV>` として先頭にtestingを付与した値で`APP_ENV`を上書きし実行します。
(サーバー環境変数として`APP_ENV`が定義されていることを前提としています。)

それ以降の引数は、phpunitの引数と同様です。（そのままphpunitに渡されます。）


### 実行例

※ 環境変数APP_ENVで環境名が定義されてる前提で説明しています

```sh
# 現環境のテスト環境で実行（ testing-<APP_ENV> として実行 ）
./cmd-test.sh test --stop-on-failure tests/Unit/EnvTest.php
./cmd-test.sh test --stop-on-failure --testsuite Seller-Unit

# 環境を指定して実行 ( testing-local-development を指定 )
./cmd-test.sh test-by-env testing-local-development --stop-on-failure tests/Unit/EnvTest.php
./cmd-test.sh test-by-env testing-local-development --stop-on-failure --testsuite Seller-Unit
```

### オプション別実行例

※ 環境変数APP_ENVで環境名が定義されてる前提で説明しています

```sh
# 現環境のテスト環境で実行（ testing-<APP_ENV> として実行 ）
./cmd-test.sh test tests/Unit/EnvTest.php

# 環境を指定して実行 ( testing-local-development を指定 )
./cmd-test.sh test-by-env testing-local-development tests/Unit/EnvTest.php

# テスト失敗時に停止させる ( --stop-on-failure )
./cmd-test.sh test --stop-on-failure tests/Unit/EnvTest.php

# テストパスを指定して実行 (tests/Unit/EnvTest.php や tests/Unit)
./cmd-test.sh test tests/Unit/EnvTest.php
./cmd-test.sh test tests/Unit

# TestSuitを指定して実行 (--testsuite <name> で 指定名は phpunit.xml参照)
./cmd-test.sh test --testsuite Seller
./cmd-test.sh test --testsuite Shop
./cmd-test.sh test --testsuite Shop-Unit
./cmd-test.sh test --testsuite Common-Unit
```

### 合格すべきコマンド（個別）

※ 環境変数APP_ENVで環境名が定義されてる前提で説明しています

```sh
# ショップの場合
./cmd-test.sh test --testsuite Shop

# ショップ運営の場合
./cmd-test.sh test --testsuite Seller

# 管理の場合
./cmd-test.sh test --testsuite Admin
```

### 合格すべきコマンド（一括）

下記の「ローカル全部まとめて」実行する場合は、下記の.envファイルの準備が完了してある必要があります。
- .env.testing-local-shop-development
- .env.testing-local-seller-development
- .env.testing-local-admin-development
- .env.testing-local-batch-development

```sh
# ローカル全部まとめて
./cmd-test.sh test-all-local
```
