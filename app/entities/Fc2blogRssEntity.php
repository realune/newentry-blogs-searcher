<?php

require_once 'Entity.php';
require_once __DIR__ . '/../functions/Fc2blogParser.php';

class Fc2blogRssEntity extends Entity
{
    private $link;
    private $title;
    private $description;
    private $username;
    private $serverNo;
    private $entryNo;
    private $entryDate;

    /**
     * constructor
     * URLをパースしたい場合は$parseにtrueを設定
     * @param $link
     * @param $title
     * @param $description
     * @param $entryDate
     * @param $parse
     */
    public function __construct($link, $title, $description, $entryDate, $parse = false)
    {
        $this->setLink($link);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setentryDate($entryDate);
        if ($parse) {
            // URLをパースしてユーザー名、サーバー番号、エントリーNoを取得
            $parsedArr = Fc2blogParser::parseUrl($this->link);
            $this->setUsername($parsedArr['username']);
            $this->setServerNo($parsedArr['serverNo']);
            $this->setEntryNo($parsedArr['entryNo']);
        }
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
     * entryDateを取得する
     * @return $entryDate
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * entryDateを設定する
     * @param $entryDate
     * @return void
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
    }
}
