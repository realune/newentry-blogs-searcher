<?php

require_once 'Model.php';
require_once __DIR__ . '/../functions/DateUtil.php';

const TABLE_NAME = 'newentry_blogs';

class NewentryBlogsModel extends Model
{
    /**
     * データをinsertする
     * $commitCountに指定した件数ごとにコミットを行う
     * @param $entityList
     * @param $commitCount = 10000
     * @return void
     */
    public function insert($entityList, $commitCount = 10000)
    {
        $pdo = $this->connect();
        // 定数を展開するための無名関数
        $_ = function($s) {return $s;};
        // プリペアドステートメントを用意
        $stmt = $pdo->prepare(
            "INSERT INTO {$_(TABLE_NAME)} (link, title, description, username, serever_no, entry_no, entry_date) "
            . 'VALUES (:link, :title, :description, :username, :serever_no, :entry_no, :entry_date)'
        );

        $counter = 0;
        $pdo->beginTransaction();
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
                    $pdo->commit();
                    $counter = 0;
                    $pdo->beginTransaction();
                }
            }
            $pdo->commit();
        } catch (PDOException $e) {
            // ロールバック
            $pdo->rollBack();
            // 外側のTryブロックに対してスロー
            throw $e;
        }
    }
}
