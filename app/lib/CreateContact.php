<?php

namespace App\Lib;

class CreateContact
{
    use \App\Lib\Traits\GetDictionary;
    use \App\Lib\Traits\PutContentToFile;

    public function create($name, $phone_number)
    {
        $san_name = SanitizeFileName::run($name);
        $san_number = phone_number_to_db($phone_number);
        $dictionary = $this->getDictionary(DICTIONARY);
        if ($dictionary === false) {
            return false;
        } else {
            if (!empty($dictionary)) {
                if (\is_array($dictionary)) {
                    if (array_key_exists($san_name, $dictionary)) {
                        if ($dictionary[$san_name] !== $san_number) {
                            $dictionary[$san_name] = $dictionary[$san_name].', '.$san_number;
                        } else {
                            $dictionary[$san_name] = $san_number;
                        }
                    } else {
                        $dictionary[$san_name] = $san_number;
                    }
                }
            } else {
                $dictionary[$san_name] = $san_number;
            }
        }

        return $this->put(DICTIONARY, json_encode($dictionary), 0664, false);
    }
}
