<?php

require_once 'Model.php';
require_once __DIR__ . '/../functions/DateUtil.php';
require_once __DIR__ . '/../entities/NewentryBlogsEntity.php';

const TABLE_NAME = 'newentry_blogs';

/**
 * FC2新着ブログモデル
 */
class NewentryBlogsModel extends Model
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * FC2新着ブログのデータを取得する
     * @param $entryDate
     * @param $link
     * @param $username
     * @param $serverNo
     * @param $entryNo
     * @param $startDispNum
     * @param $searchTargetList
     * @return void
     */
    public function getBySearchCond(
        $entryDate,
        $link,
        $username,
        $serverNo,
        $entryNo,
        $startDispNum,
        $searchTargetList)
    {
        // 検索後のデータを格納する変数
        $retEntityList = [];

        // SQL文の組み立て
        $sql = 'SELECT * FROM ' . TABLE_NAME . ' WHERE 1=1';
        // 日付検索は時間を指定しないため、データをdatetime型からdate型へキャストして検索する
        if ($searchTargetList['entry_date']) $sql .= ' AND CAST(entry_date AS DATE) = :entry_date';
        if ($searchTargetList['link'])       $sql .= ' AND link = :link';
        if ($searchTargetList['username'])   $sql .= ' AND username = :username';
        if ($searchTargetList['server_no'])  $sql .= ' AND server_no = :server_no';
        if ($searchTargetList['entry_no']) {
            if ($searchTargetList['entry_no_over']) {
                $sql .= ' AND entry_no >= :entry_no';
            } else {
                $sql .= ' AND entry_no = :entry_no';
            }
        }
        // 投稿日時の新しい順
        $sql .= ' ORDER BY entry_date DESC';
        // ページ番号に対応するデータを指定する
        $sql .= ' LIMIT :start_disp_num, :disp_cnt;';

        // プリペアドステートメントを用意
        $stmt = $this->pdo->prepare($sql);
        // バインド処理
        if ($searchTargetList['entry_date']) $stmt->bindValue('entry_date', $entryDate);
        if ($searchTargetList['link'])       $stmt->bindValue('link', $link);
        if ($searchTargetList['username'])   $stmt->bindValue('username', $username);
        if ($searchTargetList['server_no'])  $stmt->bindValue('server_no', $serverNo);
        if ($searchTargetList['entry_no'])   $stmt->bindValue('entry_no', $entryNo);
        $stmt->bindValue('start_disp_num', $startDispNum);
        $stmt->bindValue('disp_cnt', Constant::FC2BLOG_DISPLAY_CNT);

        try {
            // データを検索する
            $stmt->execute();
        } catch (PDOException $e) {
            throw $e;
        }
        // 取得したデータをEntityに格納する
        foreach ($stmt->fetchAll() as $row) {
            $entity = new NewentryBlogsEntity(
                $row['id'],
                $row['link'],
                $row['title'],
                $row['description'],
                $row['username'],
                $row['server_no'],
                $row['entry_no'],
                $row['entry_date'],
                $row['created_at'],
                $row['updated_at']
            );
            array_push($retEntityList, $entity);
        }

        return $retEntityList;
    }

    /**
     * データ件数を取得する
     */
    public function getCount(
        $entryDate,
        $link,
        $username,
        $serverNo,
        $entryNo,
        $searchTargetList)
    {
        // 検索後の件数を格納する変数
        $retCount = 0;

        // SQL文の組み立て
        $sql = 'SELECT count(*) FROM ' . TABLE_NAME . ' WHERE 1=1';
        // 日付検索は時間を指定しないため、データをdatetime型からdate型へキャストして検索する
        if ($searchTargetList['entry_date']) $sql .= ' AND CAST(entry_date AS DATE) = :entry_date';
        if ($searchTargetList['link'])       $sql .= ' AND link = :link';
        if ($searchTargetList['username'])   $sql .= ' AND username = :username';
        if ($searchTargetList['server_no'])  $sql .= ' AND server_no = :server_no';
        if ($searchTargetList['entry_no']) {
            if ($searchTargetList['entry_no_over']) {
                $sql .= ' AND entry_no >= :entry_no';
            } else {
                $sql .= ' AND entry_no = :entry_no';
            }
        }
        $sql .= ';';

        // プリペアドステートメントを用意
        $stmt = $this->pdo->prepare($sql);
        // バインド処理
        if ($searchTargetList['entry_date']) $stmt->bindValue('entry_date', $entryDate);
        if ($searchTargetList['link'])       $stmt->bindValue('link', $link);
        if ($searchTargetList['username'])   $stmt->bindValue('username', $username);
        if ($searchTargetList['server_no'])  $stmt->bindValue('server_no', $serverNo);
        if ($searchTargetList['entry_no'])   $stmt->bindValue('entry_no', $entryNo);

        try {
            // データを検索する
            $stmt->execute();
        } catch (PDOException $e) {
            throw $e;
        }

        // 件数を取得
        $retCount = $stmt->fetchColumn();
        
        return $retCount;
    }

    /**
     * データをinsertする
     * $commitCountに指定した件数ごとにコミットを行う
     * @param $entityList
     * @param $commitCount = 10000
     * @return void
     */
    public function insert($entityList, $commitCount = 10000)
    {
        // 定数を展開するための無名関数
        $_ = function ($s) {return $s;};

        // プリペアドステートメントを用意
        // ユーザー名、エントリー番号、投稿日で重複レコードを判定し、重複の場合は挿入しない
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$_(TABLE_NAME)} (link, title, description, username, server_no, entry_no, entry_date) "
            . "SELECT :link, :title, :description, :username, :server_no, :entry_no, :entry_date "
            . "WHERE NOT EXISTS (SELECT * FROM {$_(TABLE_NAME)} "
            . "WHERE username = :username_sub AND entry_no = :entry_no_sub AND entry_date = :entry_date_sub)"
        );

        $counter = 0;
        $this->pdo->beginTransaction();
        try {
            foreach ($entityList as $entity) {
                $counter++;
                $entryDate = DateUtil::formatDatetime($entity->getEntryDate());

                $stmt->execute([
                    'link' => $entity->getLink(),
                    'title' => $entity->getTitle(),
                    'description' => $entity->getDescription(),
                    'username' => $entity->getUsername(),
                    'server_no' => $entity->getServerNo(),
                    'entry_no' => $entity->getEntryNo(),
                    'entry_date' => $entryDate,
                    'username_sub' => $entity->getUsername(),
                    'entry_no_sub' => $entity->getEntryNo(),
                    'entry_date_sub' => $entryDate
                ]);

                // コミット件数に達した場合コミットする
                if ($counter >= $commitCount) {
                    $this->pdo->commit();
                    $counter = 0;
                    $this->pdo->beginTransaction();
                }
            }
            $this->pdo->commit();
        } catch (PDOException $e) {
            // ロールバック
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * 更新日時が指定日数以前のデータを削除する
     * @param $days
     * @return void
     */
    public function deleteByUpdatedAtBefore($days)
    {
        // 削除対象日時を取得
        $targetDatetime = DateUtil::getBeforeDatetime($days);

        // 定数を展開するための無名関数
        $_ = function ($s) {return $s;};
        // プリペアドステートメントを用意
        $stmt = $this->pdo->prepare(
            "DELETE FROM {$_(TABLE_NAME)} WHERE updated_at <= :updated_at"
        );

        $this->pdo->beginTransaction();
        try {
            $stmt->execute(['updated_at' => $targetDatetime]);
            $this->pdo->commit();
        } catch (PDOException $e) {
            // ロールバック
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
