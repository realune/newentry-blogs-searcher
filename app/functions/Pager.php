<?php

/**
 * ページネーションを提供するクラス
 */
class Pager
{
    /**
     * ページ番号の設定
     * @param $smarty smartyインスタンス
     * @param $dataCount データ件数
     * @param $currentPage 現在のページ番号
     * @param $perPage 1ページあたりの表示件数
     * @param $pageRange $currentPageから前後何件のページ番号を表示するか
     */
    public function setPages($smarty, $dataCount, $currentPage = 1, $perPage = 10, $pageRange = 5)
    {
        // 最大ページ数の計算
        $totalPage = ceil($dataCount / $perPage);
        // 現在のページ
        $currentPage = (int) htmlspecialchars($currentPage);

        // ページ番号の始点と終点の計算
        // マイナスやオーバーを防ぐためmax,minで補正
        $start = max($currentPage - $pageRange, 2);
        $end = min($currentPage + $pageRange, $totalPage - 1);

        // 現在のページ前後に表示するページ番号を格納する
        $pageNums = [];
        for ($i = $start; $i <= $end; $i++) {
            $pageNums[] = $i;
        }

        // assignメソッドを使ってテンプレートに渡す値を設定
        $smarty->assign('total_page', $totalPage);
        $smarty->assign('current_page', $currentPage);
        $smarty->assign('end', $end);
        $smarty->assign('page_nums', $pageNums);
    }
}
