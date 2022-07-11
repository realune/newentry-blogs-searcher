<?php
/**
 * 過去のブログ記事データを削除する
 */

require_once __DIR__ . '/../Constant.php';
require_once __DIR__ . '/../app/models/NewentryBlogsModel.php';
require_once __DIR__ . ('/../app/exceptions/XmlReadException.php');
require 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// ログ初期化
$log = new Logger('app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../tmp/logs/application.log', Logger::INFO));

$log->info('FC2BLOG 新着記事RSS削除処理 開始');

$newentryModel = new NewentryBlogsModel();
try {
    // 指定日数以前のデータを削除する
    $newentryModel->delete_by_updated_at_before(Constant::FC2BLOG_DELETE_BEFORE);
} catch (PDOException $e) {
    // エラー時ログ出力
    $log->error($e);
    exit("処理に失敗しました。\n");
}

$log->info('FC2BLOG 新着記事RSS削除処理 終了');
