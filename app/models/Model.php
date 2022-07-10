<?php

require_once __DIR__ . '/../../database/DbConnect.php';

class Model
{
    /**
     * DBに接続する
     * @return $pdo
     */
    protected function connect()
    {
        $db = new DbConnect();
        $pdo = $db->connect();

        return $pdo;
    }
}
