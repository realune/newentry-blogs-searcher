<?php

require_once __DIR__ . '/../app/entities/Fc2blogRssEntity.php';
require_once __DIR__ . '/../app/functions/XmlUtil.php';
require_once __DIR__ . '/../app/models/NewentryBlogsModel.php';
require_once __DIR__ . ('/../app/exceptions/XmlReadException.php');
require 'vendor/autoload.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

const DC = 'dc';

// ログ初期化
$log = new Logger('app');
$log->pushHandler(new StreamHandler(__DIR__ . '/../tmp/logs/application.log', Logger::INFO));

$log->info('FC2BLOG 新着記事RSS取得処理 開始');
// 取得したいRSSのURLを設定
$url = 'http://blog.fc2.com/newentry.rdf';

try {
    $rss = XmlUtil::readRss($url);
} catch (XmlReadException $e) {
    $log->error($e);
    $log->error("RSS取得URL: $url");
    return;
}

$entityList = [];
foreach ($rss->item as $item) {
    // simplexml_load_fileでは名前空間プレフィックス付きのタグが読み込めないため
    // 子ノードのタグを指定して読み込む
    $dcNode = $item->children(DC, true);

    $entity = new Fc2blogRssEntity(
        $item->link->__toString(),
        $item->title->__toString(),
        $item->description->__toString(),
        $dcNode->date->__toString(),
        true
    );

    array_push($entityList, $entity);
}

$newentryModel = new NewentryBlogsModel();
try {
    // RSSデータをデータベースにinsert
    $newentryModel->insert($entityList);
} catch (PDOException $e) {
    // エラー時ログ出力
    $log->error($e);
}

$log->info('FC2BLOG 新着記事RSS取得処理 終了');
