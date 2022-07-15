<?php

/**
 * 空チェック
 * 0と'0'を空とみなさない
 */
function is_empty($value)
{
    if (empty($value) && 0 !== $value && '0' !== $value) {
        return true;
    } else {
        return false;
    }
}
