USE fc2blog;

CREATE TABLE IF NOT EXISTS `newentry_blogs` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL COMMENT 'ID',
  `link` VARCHAR(8500) COMMENT 'URL',
  `title` VARCHAR(1000) COMMENT 'タイトル',
  `description` TEXT COMMENT '本文',
  `username` VARCHAR(50) COMMENT 'ユーザー名',
  `server_no` INT UNSIGNED DEFAULT NULL COMMENT 'サーバー番号',
  `entry_no` INT UNSIGNED COMMENT 'エントリー番号',
  `entry_date` DATETIME COMMENT 'ブログ投稿日時',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
  PRIMARY KEY (`id`),
  KEY `index1` (`username`,`entry_no`,`entry_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'FC2新着ブログテーブル';
