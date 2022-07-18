# FC2ブログ新着RSS #
* cronにより5分に一度、FC2BLOGの新着情報RSSを取得し、DBに保存
	* ユーザー名とエントリーNo.はブログのURLから取得
	* フォーマット: http://(ユーザー名).blog(サーバー番号).fc2.com/blog-entry-(エントリーNo.).html
	
* DBに保存したデータは、2週間以上古いデータは自動削除

* 検索条件を指定すると、その条件に一致したブログの一覧を表示
	* 検索条件は、日付、URL、ユーザー名、サーバー番号、エントリーNo.
	* 表示内容は日付、URL、タイトル、説明
	* 記事は新着から表示
	* 10件1ページのページャー機能
	* 各検索条件は、無指定にも対応
	* エントリーNo.の検索条件は「エントリーNo.が○○以上」を指定可能
	* 一度指定した検索条件はCookieに保存し、次回の訪問時にフォーム内に表示

## PHP
PHP 8.0+

## Database
MySQL 5.7+

## 環境構築手順
1. コンソールからサーバへ接続  
`$ ssh {ユーザ名}@{ホスト名} -p {ポート番号}`  
* 公開鍵認証の場合  
`$ ssh -i {公開鍵} {ユーザ名}@{ホスト名} -p {ポート番号}`  
<br>
2. パスワードを入力して接続  
<br>
3. public_htmlディレクトリへ移動  
`$ cd public_html`  
<br>
4. Git clone（※public_html直下に他のファイルがある場合はエラーが出るため、移動するか消すこと）  
`$ git clone https://realune@bitbucket.org/realune/newently-fc2blog-searcher.git .`  
<br>
5. composer install  
`$ composer install`  
* 下記のエラーが出る場合はphpのバージョンを指定して実行すること  
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
Your requirements could not be resolved to an installable set of packages.  
`$ php8.0 /usr/bin/composer install`　　 
<br>
6. ログファイル格納ディレクトリを作成する  
`$ mkdir -p tmp/logs`  
<br>
7. DBを作成する  
`$ mysql -u {ユーザ名} -p < database/migrations/createSchema.sql`  
<br>
8. テーブルを作成する  
`$ mysql -u {ユーザ名} -p < createNewentryBlogsTable.sql`  
<br>
9. 環境設定ファイル名を変更する  
`$ mv config/.env.example.php config/.env.php`  
<br>
10. MySQLの接続情報を記入する  
`$ vi config/.env.php`  
```
define('DB_HOST', '{環境に合わせて設定}');  
define('DB_NAME', 'exam0143');  
define('DB_USER', '{環境に合わせて設定}');  
define('DB_PASS', '{環境に合わせて設定}');  
```  
<br>
11. .htaccessを作成（または編集）する  
`$ vi .htaccess`  
* 下記を入力して保存する  
```
IndexIgnore *

RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]

<Files ~ ".(log|csv|ini|dat|tpl|yml|json|lock|tpl|sql|conf)$">
deny from all
</Files>
```  
<br>
12. バッチの権限を変更する  
`$ chmod 755 bin/AddNewEntry.php`  
`$ chmod 755 bin/DeleteOldEntry.php`  
<br>
13. cronを設定する  
`crontab -e`  
```
*/5 * * * * /usr/bin/php8.0 /home/{環境に合わせて設定}/public_html/bin/AddNewEntry.php
0 3 * * * /usr/bin/php8.0 /home/{環境に合わせて設定}/public_html/bin/DeleteOldEntry.php
```  
* phpの実行ディレクトリが違う場合は下記コマンドで確認すること  
`$ which php`  

## その他
* タイムゾーンが違う場合php.iniを修正して国に合わせる  
`date.timezone = Europe/Amsterdam`  