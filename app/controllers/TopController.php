<?php

require_once 'Controller.php';

/**
 * トップコントローラ
 */
class TopController extends Controller
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * トップページを表示する
     */
    public function index()
    {
        // テンプレートを表示する
        $this->smarty->display("top.tpl");
    }
}
