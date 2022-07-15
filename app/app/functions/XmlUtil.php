<?php

require_once __DIR__ . ('/../exceptions/XmlReadException.php');

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

        if (!$xml) {
            $errorMessage = 'RSSの取得に失敗しました。: ';
            foreach (libxml_get_errors() as $error) {
                $errorMessage .= $error->message;
            }
            libxml_clear_errors();
            throw new XmlReadException($errorMessage);
        }

        return $xml;
    }
}
