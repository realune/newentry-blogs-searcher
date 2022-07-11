<?php

require_once 'Model.php';
require_once __DIR__ . '/../functions/DateUtil.php';

const TABLE_NAME = 'newentry_blogs';

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
     * データをinsertする
     * $commitCountに指定した件数ごとにコミットを行う
     * @param $entityList
     * @param $commitCount = 10000
     * @return void
     */
    public function insert($entityList, $commitCount = 10000)
    {
        // 定数を展開するための無名関数
        $_ = function($s) {return $s;};
        // プリペアドステートメントを用意
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$_(TABLE_NAME)} (link, title, description, username, serever_no, entry_no, entry_date) "
            . 'VALUES (:link, :title, :description, :username, :serever_no, :entry_no, :entry_date)'
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
                    'serever_no' => $entity->getServerNo(),
                    'entry_no' => $entity->getEntryNo(),
                    'entry_date' => $entryDate
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
    public function delete_by_updated_at_before($days)
    {
        // 削除対象日時を取得
        $targetDatetime = DateUtil::getBeforeDatetime($days);

        // 定数を展開するための無名関数
        $_ = function($s) {return $s;};
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
