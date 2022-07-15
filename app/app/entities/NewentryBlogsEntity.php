<?php

require_once 'Entity.php';
require_once __DIR__ . '/../functions/Fc2blogParser.php';

/**
 * FC2新着ブログエンティティ
 */
class NewentryBlogsEntity extends Entity
{
    /**
     * コンストラクタ
     * @param $id
     * @param $link
     * @param $title
     * @param $description
     * @param $username
     * @param $serverNo
     * @param $entryNo
     * @param $entryDate
     * @param $createdAt
     * @param $updatedAt
     */
    public function __construct(
        private $id,
        private $link,
        private $title,
        private $description,
        private $username,
        private $serverNo,
        private $entryNo,
        private $entryDate,
        private $createdAt,
        private $updatedAt
    ) {
        $this->setId($id);
        $this->setLink($link);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setUsername($username);
        $this->setServerNo($serverNo);
        $this->setEntryNo($entryNo);
        $this->setEntryDate($entryDate);
        $this->setCreatedAt($createdAt);
        $this->setUpdatedAt($updatedAt);
    }

    /**
     * IDを取得する
     * @return $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * IDを設定する
     * @param $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * リンク(URL)を取得する
     * @return $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * リンク(URL)を設定する
     * @param $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * titleを取得する
     * @return $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * titleを設定する
     * @param $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * descriptionを取得する
     * @return $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * descriptionを設定する
     * @param $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * usernameを取得する
     * @return $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * usernameを設定する
     * @param $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * サーバ番号を取得する
     * @return $serverNo
     */
    public function getServerNo()
    {
        return $this->serverNo;
    }

    /**
     * サーバ番号を設定する
     * @param $serverNo
     * @return void
     */
    public function setServerNo($serverNo)
    {
        $this->serverNo = $serverNo;
    }

    /**
     * エントリー番号を取得する
     * @return $entryNo
     */
    public function getEntryNo()
    {
        return $this->entryNo;
    }

    /**
     * エントリー番号を設定する
     * @param $entryNo
     * @return void
     */
    public function setEntryNo($entryNo)
    {
        $this->entryNo = $entryNo;
    }

    /**
     * エントリー日時を取得する
     * @return $entryDate
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * エントリー日時を設定する
     * @param $entryDate
     * @return void
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
    }

    /**
     * 登録日時を取得する
     * @return $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 登録日時を設定する
     * @param $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * 更新日時を取得する
     * @return $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * 更新日時を設定する
     * @param $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * URLパース処理
     * @return void
     */
    public function parseUrl()
    {
        // URLをパースしてユーザー名、サーバー番号、エントリーNoを取得
        $parsedArr = Fc2blogParser::parseUrl($this->link);
        $this->setUsername($parsedArr['username']);
        $this->setServerNo($parsedArr['serverNo']);
        $this->setEntryNo($parsedArr['entryNo']);
    }
}
