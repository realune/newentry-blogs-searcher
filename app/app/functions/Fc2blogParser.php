<?php

require_once 'Parser.php';

class Fc2blogParser extends Parser
{
    /**
     * URLからユーザー名、サーバー番号、エントリーNoを取得する
     * 以下のフォーマットに対応
     *  http://(ユーザー名).blog(サーバー番号).fc2.com/blog-entry-(エントリーNo.).html
     * @param $url
     * @return $retArr
     */
    public static function parseUrl($url)
    {
        $retArr = [];

        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'];
        $path = $parsedUrl['path'];

        // ユーザー名
        preg_match('/^(?P<username>[\w\-]+)/', $host, $matchUsername);
        $username = $matchUsername['username'];
        // サーバー番号
        preg_match('/.blog(?P<serverNo>\d+)/', $host, $matchServerNo);
        $serverNo = array_key_exists('serverNo', $matchServerNo) ? $matchServerNo['serverNo'] : null;
        // エントリーNo
        preg_match('/\/blog-entry-(?P<entryNo>\d+)/', $path, $matchEntryNo);
        $entryNo = $matchEntryNo['entryNo'];

        $retArr['username'] = $username;
        $retArr['serverNo'] = $serverNo;
        $retArr['entryNo'] = $entryNo;

        return $retArr;
    }
}
