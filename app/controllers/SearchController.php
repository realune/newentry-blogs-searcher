<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/NewentryBlogsModel.php';

/**
 * 検索コントローラ
 */
class SearchController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * パラメータに指定された条件をもとに検索する
     * @param $request
     * @return void
     */
    public function search($request)
    {
        // 検索対象を取得する
        $searchTargetList = $this->getTargetList($request);

        // リクエストデータを取得
        $entryDate = ($searchTargetList['entry_date']) ? $request['entry_date'] : '';
        $link      = ($searchTargetList['link']) ? $request['link'] : '';
        $username  = ($searchTargetList['username']) ? $request['username'] : '';
        $serverNo  = ($searchTargetList['server_no']) ? $request['server_no'] : '';
        $entryNo   = ($searchTargetList['entry_no']) ? $request['entry_no'] : '';

        // Cookieに検索条件を保存
        $this->setCookie($entryDate, $link, $username, $serverNo, $entryNo, $searchTargetList['entry_no_over']);

        // エスケープ処理(XSS対策)
        $entryDate = htmlspecialchars($entryDate, ENT_QUOTES);
        $link      = htmlspecialchars($link, ENT_QUOTES);
        $username  = htmlspecialchars($username, ENT_QUOTES);
        $serverNo  = htmlspecialchars($serverNo, ENT_QUOTES);
        $entryNo   = htmlspecialchars($entryNo, ENT_QUOTES);

        $model = new NewentryBlogsModel();
        try {
            // DBからデータを取得する
            $entityList = $model->getBySearchCond(
                $entryDate,
                $link,
                $username,
                $serverNo,
                $entryNo,
                $searchTargetList
            );
        } catch (PDOException $e) {
            $this->log->error($e);
            // テンプレートを表示する
            $this->smarty->display("top.tpl");
        }

        // assignメソッドを使ってテンプレートに渡す値を設定
        $this->smarty->assign("results", $entityList);

        // テンプレートを表示する
        $this->smarty->display("search_result.tpl");
    }

    /**
     * パラメータから検索対象を特定、配列に格納して返却する
     * @param $request
     * @return @searchTargetList
     */
    private function getTargetList($request) {
        $searchTargetList = [];
        // 検索対象を判定して配列に格納
        $searchTargetList['entry_date']    = (isset($request['entry_date']) && !empty($request['entry_date']));
        $searchTargetList['link']          = (isset($request['link']) && !empty($request['link']));
        $searchTargetList['username']      = (isset($request['username']) && !empty($request['username']));
        $searchTargetList['server_no']     = (isset($request['server_no']) && !empty($request['server_no']));
        $searchTargetList['entry_no']      = (isset($request['entry_no']) && !empty($request['entry_no']));
        $searchTargetList['entry_no_over'] = (isset($request['entry_no_over']) && !empty($request['entry_no_over']));

        return $searchTargetList;
    }

    /**
     * Cookieに検索条件を保存する
     * @param $entryDate
     * @param $link
     * @param $username
     * @param $serverNo
     * @param $entryNo
     * @param $isEntryNoOver
     * @return void
     */
    private function setCookie($entryDate, $link, $username, $serverNo, $entryNo, $isEntryNoOver) {
        // クッキーに検索条件を保存
        $searchCond = [
            'entry_date'    => $entryDate,
            'link'          => $link,
            'username'      => $username,
            'server_no'      => $serverNo,
            'entry_no'       => $entryNo,
            'entry_no_over' => $isEntryNoOver
        ];
        setcookie('search_cond', json_encode($searchCond), time() + (365 * 24 * 60 * 60));
    }
}
