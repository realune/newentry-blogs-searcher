<?php

$requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$getRequest = $_GET;

// ルーティング
switch ($requestUrl) {
    case '':
    case '/':
        require_once 'app/controllers/TopController.php';
        $controller = new TopController();
        $controller->index();
        break;

    case '/search':
        require_once 'app/controllers/SearchController.php';
        $controller = new SearchController();
        $controller->search($getRequest);
        break;

    default:
        http_response_code(404);

        require_once 'config/config.php';
        require './vendor/autoload.php';
        // Smartyのインスタンスを生成
        $smarty = new Smarty();
        // テンプレートディレクトリとコンパイルディレクトリを読み込む
        $smarty->template_dir = TEMPLATE_DIR;
        $smarty->compile_dir = TEMPLATE_C_DIR;
        // テンプレートを表示する
        $smarty->display("error/404.tpl");

        break;
}
