<?php

Class Constant
{
    /**
     * FC2BLOG 新着記事
     */
    // FC2BLOG新着RSSのURL
    const FC2BLOG_NEWENTRY_RSS_URL = 'http://blog.fc2.com/newentry.rdf';
    // FC2BLOG新着RSSの名前空間プレフィックス
    const FC2BLOG_PREFIX_DC = 'dc';
    // FC2BLOG新着データの削除対象日（設定した日付以前を削除）
    const FC2BLOG_DELETE_BEFORE = 14;
    // 1ページあたりの表示件数
    const FC2BLOG_DISPLAY_CNT = 10;
}
