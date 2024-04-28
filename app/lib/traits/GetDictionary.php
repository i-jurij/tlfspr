<?php

namespace App\Lib\Traits;

trait GetDictionary
{
    public function getDictionary($filename)
    {
        if (\is_readable($filename)) {
            $jsonData = getContentOrCreateFile($filename);
            $dataArray = json_decode($jsonData, true);

            return $dataArray;
        } else {
            return false;
        }
    }
}
