<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Constant.php';
require_once __DIR__ . '/../functions/Pager.php';
require './vendor/autoload.php';
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * コントローラ親クラス
 */
class Controller
{
    protected $log;
    protected $smarty;

    /**
     * コンストラクタ
     */
    protected function __construct()
    {
        // ログ初期化
        $this->log = new Logger('Controller');
        $this->log->pushHandler(new StreamHandler(__DIR__ . '/../../tmp/logs/' . APP_LOG, Logger::WARNING));

        // Smartyのインスタンスを生成
        $this->smarty = new Smarty();
        // テンプレートディレクトリとコンパイルディレクトリを読み込む
        $this->smarty->template_dir = TEMPLATE_DIR;
        $this->smarty->compile_dir = TEMPLATE_C_DIR;
    }
}
