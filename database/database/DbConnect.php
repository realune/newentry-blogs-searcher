<?php

require_once __DIR__ . '/../config/.env.php';
require_once __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class DbConnect
{
    /**
     * データベースに接続する
     * @return $pdo
     */
    public function connect()
    {
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        try {
            // データベースに接続
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            // ログ初期化
            $log = new Logger('DbConnect');
            $log->pushHandler(new StreamHandler(__DIR__.'/../tmp/logs/' . APP_LOG, Logger::WARNING));
            $log->error($e);
            exit($e->getMessage());
        }

        return $pdo;
    }
}
