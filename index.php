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
// TODO
//        require __DIR__ . 'template/404.tpl';
        break;
}
