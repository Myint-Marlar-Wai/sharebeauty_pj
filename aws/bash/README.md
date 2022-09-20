# Bash for Fargate

aws fargateのコンテナ内に入るためのコマンド

## 必要条件

- AWS CLI
- Session Manager
- bash用のiam ユーザー
- EnableExecuteCommandがtrueのサービス

## 初期設定

- AWS CLI をインストール
  - https://docs.aws.amazon.com/ja_jp/cli/latest/userguide/getting-started-install.html
- Session Manager プラグインのインストール
  - https://docs.aws.amazon.com/ja_jp/systems-manager/latest/userguide/session-manager-working-with-install-plugin.html
- AWS CLIにiamユーザーのアクセスキーを設定します
  - aws configure --profile <your_profile_name>
  - profileはデフォルトではなく、名前を指定します。（この後、名前を使用します）
- var-template.shを、.var.shにコピーし、必要なら設定を修正
    - 対象のアカウント、クラスター、タスク等を指定できます。
    - 必ず、AWS_PROFILEに対象のAWSアカウントのプロファイルを指定してください。
    - gitignoreされていて、自身の環境に合わせてカスタマイズしてください。

## Bashを実行する

### 対象を対話式で選択して、bashを実行する

- ./ecc-cmd.sh bash-i を実行する 
- クラスターの一覧が表示されるので、対象のクラスターの名前部分を入力
- サービスの一覧が表示されるので、対象のサービスの名前部分を入力
- タスクIDの一覧が表示されるので、対象のタスクIDを入力
  - 一覧されない場合は、タスクが起動していません
- コンテナの一覧が表示されるので、対象のコンテナの名前を入力
- 確認で対象の変数一覧が表示されるので、OKでしたらyを入力します
- コンテナ内でbashが実行されます
- EnableExecuteCommandが有効化されていないサービスでは実行できません。

### 予め指定した対象のbashを実行する

- 上記コマンドで対象の変数一覧が表示されるので、それをvar.shに設定します。
- ./ecc-cmd.sh bash を実行する 
- コンテナ内でbashが実行されます
- EnableExecuteCommandが有効化されていないサービスでは実行できません。
