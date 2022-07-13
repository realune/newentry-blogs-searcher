<?php

require_once 'Controller.php';
require_once __DIR__ . '/../functions/Pager.php';
require_once __DIR__ . '/../functions/ServiceUtil.php';
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
        // Cookieに検索条件を保存
        setcookie('search_cond', json_encode($request), time() + (365 * 24 * 60 * 60));

        // 検索対象を取得する
        $searchTargetList = $this->getTargetList($request);

        // リクエストデータを取得
        $entryDate = ($searchTargetList['entry_date']) ? $request['entry_date'] : '';
        $link      = ($searchTargetList['link']) ? $request['link'] : '';
        $username  = ($searchTargetList['username']) ? $request['username'] : '';
        $serverNo  = ($searchTargetList['server_no']) ? $request['server_no'] : '';
        $entryNo   = ($searchTargetList['entry_no']) ? $request['entry_no'] : '';
        $page      = ($searchTargetList['page']) ? $request['page'] : 1;

        // エスケープ処理(XSS対策)
        $entryDate = htmlspecialchars($entryDate, ENT_QUOTES);
        $link      = htmlspecialchars($link, ENT_QUOTES);
        $username  = htmlspecialchars($username, ENT_QUOTES);
        $serverNo  = htmlspecialchars($serverNo, ENT_QUOTES);
        $entryNo   = htmlspecialchars($entryNo, ENT_QUOTES);
        $page      = htmlspecialchars($page, ENT_QUOTES);

        // ページ番号に対する表示するデータの始点を計算
        $startDispNum = ($page * Constant::FC2BLOG_DISPLAY_CNT - Constant::FC2BLOG_DISPLAY_CNT);

        $entityList = [];
        $model = new NewentryBlogsModel();
        try {
            // DBからデータを取得する
            $entityList = $model->getBySearchCond(
                $entryDate,
                $link,
                $username,
                $serverNo,
                $entryNo,
                $startDispNum,
                $searchTargetList
            );

            // 検索結果の件数を取得
            $resultCount = $model->getCount(
                $entryDate,
                $link,
                $username,
                $serverNo,
                $entryNo,
                $searchTargetList
            );
        } catch (PDOException $e) {
            $this->log->error($e);
            // エラー画面を表示する
            $this->smarty->display("error/500.tpl");
            exit;
        }

        // assignメソッドを使ってテンプレートに渡す値を設定
        $this->smarty->assign("results", $entityList);

        // ページネーションを設定する
        $pager = new Pager();
        $pager->setPages($this->smarty, $resultCount, $page);

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
        $searchTargetList['entry_date']    = (isset($request['entry_date']) && !is_empty($request['entry_date']));
        $searchTargetList['link']          = (isset($request['link']) && !is_empty($request['link']));
        $searchTargetList['username']      = (isset($request['username']) && !is_empty($request['username']));
        $searchTargetList['server_no']     = (isset($request['server_no']) && !is_empty($request['server_no']) && is_numeric($request['server_no']));
        $searchTargetList['entry_no']      = (isset($request['entry_no']) && !is_empty($request['entry_no']) && is_numeric($request['entry_no']));
        $searchTargetList['entry_no_over'] = (isset($request['entry_no_over']) && !is_empty($request['entry_no_over']));
        $searchTargetList['page']          = (isset($request['page']) && !is_empty($request['page']) && is_numeric($request['page']));

        return $searchTargetList;
    }
}
