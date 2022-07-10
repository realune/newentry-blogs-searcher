<?php

require_once __DIR__ . ('/../exceptions/XmlReadException.php');
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class XmlUtil
{
    /**
     * RSSの読み込み
     * @param $url
     * @return $xml
     */
    public static function readRss($url)
    {
        // ユーザによるXMLエラー処理を有効にする
        libxml_use_internal_errors(true);
        // XMLの取得
        $xml = simplexml_load_file($url);

        if (!self::canRead($xml)) {
            throw new XmlReadException (
                'RSSの取得に失敗しました。'
            );
        }

        return $xml;
    }

    /**
     * 読み込みチェック
     * @param $xml
     * @return bool
     */
    private static function canRead($xml)
    {
        if ($xml === false) {
            // XML取得失敗時、ログにエラーを出力
            $log = new Logger('app');
            $log->pushHandler(new StreamHandler(__DIR__.'/../../tmp/logs/application.log', Logger::ERROR));
            foreach (libxml_get_errors() as $error) {
                $log->error($error->message);
            }
            libxml_clear_errors();

            return false;
        }

        return true;
    }
}
