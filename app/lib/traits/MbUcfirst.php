<?php

namespace App\Lib\Traits;

trait MbUcfirst
{
    public function mbUcfirstO($str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));

        return $fc.mb_substr($str, 1);
    }

    public function mbUcfirst($string)
    {
        $firstChar = mb_substr($string, 0, 1, mb_detect_encoding($string));
        $then = mb_substr($string, 1, null, mb_detect_encoding($string));

        return mb_strtoupper($firstChar, mb_detect_encoding($string)).$then;
    }
}
