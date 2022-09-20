# ONCE EC Web Local Docker Container

## 初期設定

1. `.env.template` を、`.env` にコピーします。
2. `web-variables-template.env` を、`web-variables.env` にコピーします。
3. 先程コピーした `.env` の設定を修正します。
    - このファイルはdocker-composeの設定です。
        - `.env` は、gitignoreされているため、自身の環境に合わせてカスタマイズしてください。
        - `APP_BUILD_ARGS_APP_ENV` に、APP_ENVを指定してください。Laravelの.envの名前に対応しています。
            - ex. `shop-development`, `seller-development`, `admin-development`...
            - コンフィグを変えながら作業する場合は、`local-development` とすると便利です。
                - `/src/.env.local-development` は、gitignoreされています。
                - `local-development`の場合は、`/src/.env.local-development`が用意されていないため、`/src/.env.xxxxxx-development`
                  からコピーして作成してください。
                - ちなみに、この場合に `local-development` である必要はなく、`local`や`local-*`であれば問題ないです。
        - 同期しない場合(開発をせず閲覧するのみの人向け)
            - `COMPOSE_FILE=docker-compose.yml` と設定してください。
            - `APP_BUILD_ARGS_FLAG_DEVELOP=false` と設定してください。ソースコードを変更しない前提の最適化が行われます。
        - volumeのマウントで同期する場合
            - `COMPOSE_FILE=docker-compose.yml:docker-compose.mount.yml` と設定してください。
            - `APP_CODE_CONTAINER_FLAG=:cached` と設定してください。お好みで変更も可です。
            - `APP_BUILD_ARGS_FLAG_DEVELOP=true` と設定してください。本番向け最適化をスキップします。
        - docker-syncで同期する場合
            - `COMPOSE_FILE=docker-compose.yml:docker-compose.sync.yml` と設定してください。
            - `APP_CODE_CONTAINER_FLAG=:nocopy` と設定してください。お好みで変更も可です。
            - Mac の場合に、`DOCKER_SYNC_STRATEGY=native_osx` を設定してください。お好みで変更も可です。
            - `APP_BUILD_ARGS_FLAG_DEVELOP=true` と設定してください。本番向け最適化をスキップします。
4. 先程コピーした `web-variables.env` の設定を修正します。
    - このファイルはコンテナの環境変数の設定です。
    - web-variables.envは、gitignoreされているため、自身の環境に合わせてカスタマイズしてください。
    - 環境変数設定は方法が大きく２つあり、こちらの`web-variables.env` に設定する方法と、 Laravelの`/src/.env.<APP_ENV>` に設定する方法があります。
        - `web-variables.env` に設定する場合
            - `web-variables.env`に設定します。
            - **APP_KEY** や **DB_PASSWORD** などの **シークレット情報** や **ローカル用のミドルウェアなどの環境変数** を設定してください。
            - この方法は、実際のサーバーと同じ仕組みになります。
        - Laravelの `/src/.env.<APP_ENV>` に設定する場合
            - `web-variables.env`の該当の環境変数を**コメントアウト** してください。
                - `web-variables.env` の変数が **優先** されてしまうためです。
            - /src側の Laravelの `/src/.env.<APP_ENV>` に設定をします。
                - カスタマイズする場合は、gitignoreされている`/src/.env.local-development`を使用し、前述した`.env`
                  の`APP_BUILD_ARGS_APP_ENV=local-development`を設定します。
            - この方法は、実際のサーバーとは異なる方法で、実際はサーバー側の環境変数で上書きする仕組みになります。
5. コンテナ起動後、コンテナ内で、Laravelディレクトリの初期設定をします。(npmやcomposer)
    - この作業は、**同期しない設定の場合は不要** です。
    - コンテナを起動し、コンテナへ入ります。（コンテナ起動とが入り方は後述）
    - コンテナへ入ったら以下のいずれかのコマンドを実行します。
        - 手動で各インストールを行う。
            - `composer install`
            - `npm install`
        - Dockerfileで実行している内容と同じことを行う。
            - `/usr/local/bin/install-project.sh`
                - ただし、js/cssのビルドも実行されます。
    - 上記が必要な理由は、/srcディレクトリ全体をホスト側と同期していて、ホスト側の状態になるためです。
    - 上記を行いたくない場合は、`node_modules/` と `vendor/` の同期をしない設定にする必要があります。

## 起動と初回ビルド

- 同期しない、もしくはvolumeマウントの場合は、`./compose.sh up` でコンテナが起動します。
- docker-sync使用の場合は、`./sync.sh up` でコンテナが起動します。
- 初回で、ビルドが完了していない場合はビルドが自動的に行われます。
- 初期設定が完了済みで、デフォルトの設定の場合、[http://localhost:8080]() でアクセスできます。
- ちなみに、Dockerfileを変更しても、この作業だけでは変更が反映されませんので「再ビルド」の項を確認ください。

## コンテナへの入り方

- 同期しない、もしくはvolumeマウントの場合は、`./compose.sh bash` でコンテナに入ります。
- docker-sync使用の場合は、`./sync.sh bash` でコンテナに入ります。
- コンテナは起動してある必要があります。

## 再ビルド

- 同期しない、もしくはvolumeマウントの場合は、`./compose.sh up --build` を実行することで再ビルドした上でコンテナが起動します。
- docker-sync使用の場合は、`./sync.sh up --build` を実行することで再ビルドした上でコンテナが起動します。
- Dockerfileやそれに関わる部分を改修した場合、こちらのコマンドで再ビルドすると反映されます。

## コンテナ環境変数

- `APP_ENV` が `development` の場合で説明すると、 Laravelの `/src/.env.development` をベースとなり、`/local/web-variables.env`
  の環境変数で上書きします。
- `/src/.env.<APP_ENV>`と一致するファイルが無い場合は `/src/.env`が使用されます。

## 停止・削除

- 同期しない、もしくはvolumeマウントの場合は、`./compose.sh stop` で停止します。
- 同期しない、もしくはvolumeマウントの場合は、`./compose.sh down` で削除します。
- docker-sync使用の場合は、`./sync.sh stop` で停止します。
- docker-sync使用の場合は、`./sync.sh down` で削除します。
