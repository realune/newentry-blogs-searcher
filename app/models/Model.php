<?php

require_once __DIR__ . '/../../database/DbConnect.php';
require_once __DIR__ . '/../../Constant.php';

class Model
{
    protected $pdo;

    /**
     * コンストラクタ 
     */
    protected function __construct() {
        $db = new DbConnect();
        $this->pdo = $db->connect();
    } 
}
