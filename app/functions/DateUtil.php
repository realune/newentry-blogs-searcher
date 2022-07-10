<?php

class DateUtil
{
    /**
     * string型の日付をY-m-d H:i:s形式のstring型に変換する
     * @param $datetime
     * @return $retDatetime
     */
    public static function formatDatetime($datetime)
    {
        $retDatetime = new DateTime($datetime);
        $retDatetime = $retDatetime->format('Y-m-d H:i:s');

        return $retDatetime;
    }
}
