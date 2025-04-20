# グルメログアプリ

店舗の予約・更新・削除ができるアプリ。
一般ユーザー(user)・店舗代表者(owner)・管理者(admin)
他、以下機能を実装
・事前支払い可能(カードのみ)
・予約当日の朝にアラートメール送信
・お気に入り追加・削除
・店舗代表者(owner)のみ店舗情報登録・更新
・管理者(admin)より利用者にお知らせメール送信
![グルメログアプリトップページ](https://github.com/user-attachments/assets/666ca47d-180b-4c0e-b0f8-0b4983ae5dd7)

## 環境構築

### Dockerビルド
1. `git clone git@github.com:hisako-ito/gourmet-log-app.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

＊ MacのM1・M2チップのPCの場合、no matching manifest for linux/arm64/v8 in the manifest list entriesのメッセージが表示されビルドができない場合があります。 エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください

```
mysql:
    platform: linux/x86_64(この文追加)`
    image: mysql:8.0.26
    environment:
```

### Laravel環境構築
1. `docker-compose exec php bash`
2. `composer install`
3. `cp .env.example .env`　　
4. envファイルの変更
```
  DB_HOSTをmysqlに変更  
　DB_DATABASEをlaravel_dbに変更  
　DB_USERNAMEをlaravel_userに変更  
　DB_PASSWORDをlaravel_passに変更  
```
5. アプリケーションキーの作成
```
php artisan key:generate
```
6. マイグレーションの実行
```
php artisan migrate
```
7. シーディングを実行する
```
php artisan db:seed
```
8. storageディレクトリ配下の再作成(開発時、誤ってstorageディレクトリを削除してしまい、再作成しないとパーミッションの問題でキャッシュクリアがうまくできません)
```
# storage配下の再作成（Laravelが必要とする構造）
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs

# 権限の再設定
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```
9. シンボリックリンクを作成する
```
php artisan storage:link
```

### ログイン情報
---

#### 一般ユーザーアカウント
**name:** 一般ユーザ1    
**email:** [general1@gmail.com](mailto:general1@gmail.com)  
**password:** password  

**name:** 一般ユーザ2    
**email:** [general2@gmail.com](mailto:general2@gmail.com)  
**password:** password  

---

#### 店舗代表者アカウント 
**name:** 店舗代表者ユーザ1～20   
**email:** [owner1@gmail.com](mailto:owner@gmail.com)  
**password:** password  
※20アカウントあります。メールアドレスのownerの数字がユーザー名の数字と一致します。

---

#### 管理者アカウント
**name:** 管理者ユーザ1      
**email:** [admin1@gmail.com](mailto:admin1@gmail.com)  
**password:** password  

**name:** 管理者ユーザ2    
**email:** [admin2@gmail.com](mailto:admin2@gmail.com)  
**password:** password  

---

> [!NOTE]
> 新規アカウント登録時は、mailhog([http://localhost/8025](http://localhost/8025))で受信するメールにて認証が必要です。

### mailhog設定
本アプリではユーザー登録の際、メールアドレス認証を実施する上で、メールサーバーとしてmailhogを設定しています。
認証メール送信元のメールアドレス設定のため、envファイルのMAIL_FROM_ADDRESSを設定してください。
```
  MAIL_FROM_ADDRESS=example@example.com  
```
※上記は任意のメールアドレスで可

envファイルの更新後、反映のため、以下コマンドでキャッシュクリアを実施してください  
```
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan config:cache
```

### Stripe設定
本アプリはStripeによる決算処理機能を実装しています。
アプリで決済機能を利用するためには、StripeのAPIキーを取得し、環境変数に設定する必要があります。  
以下の手順に従って設定を行ってください。

1. Stripeアカウントの作成  
まず、Stripe([https://stripe.com/jp](https://stripe.com/jp))にアクセスしてアカウントを作成してください。既にアカウントをお持ちの場合は、ログインしてください。

2. APIキーの取得  
ログイン後、Stripeのダッシュボードにアクセスし、以下の手順でAPIキーを取得します：

    1. ダッシュボード左側のメニューから「開発者」→「APIキー」をクリックします。
    2. 公開可能キー（pk_live_...）および シークレットキー（sk_live_...）を確認してください。
    * 開発環境ではテストモードのキー（pk_test_... と sk_test_...）を使用してください。
3. .envファイルへの設定
取得したAPIキーをアプリケーションの.envファイルに追加してください。
以下の例を参考に、適切なキーを設定してください。
```
STRIPE_PUBLIC_KEY="パブリックキー"
STRIPE_SECRET_KEY="シークレットキー"
``` 
* envファイル更新後は、反映のためキャッシュクリアを実施してください。

4. 動作確認
アプリケーションでStripe決済が正しく動作するか確認してください。
開発環境ではテストモードで動作確認を行い、必要に応じてテスト用のカード番号を使用してください。

| 項目  | 入力値 |
| ------------- | ------------- |
| カード番号  | 4242 4242 4242 4242  |
| 有効期限  | 任意の未来の日付 (例: 12/34)  |
| セキュリティコード  | 任意の3桁 (例: 123)  |

以下のリンクは公式ドキュメントです。  
[https://docs.stripe.com/payments/checkout?locale=ja-JP](https://docs.stripe.com/payments/checkout?locale=ja-JP)

## 使用技術(実行環境)
* PHP 7.4.9
* Laravel 8.83.8
* MySQL 15.1

## ER図
![gourmet-log-app](https://github.com/user-attachments/assets/da41dd17-41b5-46dc-a529-734323a8a2c7)

## URL

* 開発環境： [http://localhost/login](http://localhost/login)(一般ユーザーログイン画面)
  　　　　　　[http://localhost/owner/login](http://localhost/owner/login)(店舗代表者ログイン画面)  
  　　　　　　[http://localhost/admin/login](http://localhost/admin/login)(管理者ログイン画面) 
* phpMyAdmin： [http://localhost:8080/](http://localhost:8080/)
* mailhog： [http://localhost:8025/](http://localhost:8025/)

