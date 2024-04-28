<?php

function mbStrReplace($search, $replace, $string)
{
    $charset = mb_detect_encoding($string);

    $unicodeString = iconv($charset, 'UTF-8', $string);

    return str_replace($search, $replace, $unicodeString);
}

function getContentOrCreateFile($filename)
{
    $hits = '';
    if (file_exists($filename)) {
        $hits = file_get_contents($filename);
    } else {
        file_put_contents($filename, '');
    }

    return $hits;
}
function redirect($url, $statusCode = 303)
{
    header_remove();
    header('Location: '.$url, true, $statusCode);
    exit;
}

function getOutput($file)
{
    ob_start();
    include $file;
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
/**
 * @param string $path - dir for scan
 * @param string $ext  - extension of files eg 'png' or 'png, webp, jpg'
 *
 * @return array path to files
 */
function filesInDirScan($path, $ext = '')
{
    $files = [];
    if (file_exists($path)) {
        $f = scandir($path);
        foreach ($f as $file) {
            if (is_dir($file)) {
                continue;
            }
            if (empty($ext)) {
                $files[] = $file;
            } else {
                $arr = explode(',', $ext);
                foreach ($arr as $value) {
                    $extt = mb_strtolower(trim($value));
                    // $extt = mb_strtolower(ltrim(trim($value), '.'));
                    /*
                    if(preg_match("/\.($extt)/", $file)) {
                      $files[] = $file;
                    }
                    */
                    if ($extt === mb_strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
                        $files[] = $file;
                    }
                }
            }
        }
    }

    return $files;
}

/**
 * @param string $dir - dir for scan
 * @param string $ext - extension of files eg 'png' or 'png, webp, jpg'
 *
 * @return array basename  of files or false
 */
function filesInDirIter($dir, $ext = '')
{
    if (file_exists($dir) && is_dir($dir) && is_readable($dir)) {
        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            if (empty($ext)) {
                $files[] = $fileInfo->getBasename();
            } else {
                $arr = explode(',', $ext);
                foreach ($arr as $value) {
                    $extt = mb_strtolower(ltrim(trim($value), '.'));
                    if ($extt === $fileInfo->getExtension()) {
                        $files[] = $fileInfo->getBasename();
                    }
                }
            }
        }
    } else {
        return false;
    }

    return $files;
}
/**
 * replacing FILTER_SANITIZE_STRING.
 */
function filterString(string $string): string
{
    $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
    $str = str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
    if (!empty($str)) {
        return $str;
    } else {
        return false;
    }
}

function sanitize($filename)
{
    // remove HTML tags
    $filename = strip_tags($filename);
    // remove non-breaking spaces
    $filename = preg_replace("#\x{00a0}#siu", ' ', $filename);
    // remove illegal file system characters
    $filename = str_replace(array_map('chr', range(0, 31)), '', $filename);
    // remove dangerous characters for file names
    $chars = [
        '?', '[', ']', '/', '\\', '=', '<', '>', ':', ';', ',', "'", '"', '&', '’', '%20',
        '+', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+', '^', chr(0),
    ];
    $filename = str_replace($chars, '_', $filename);
    // remove break/tabs/return carriage
    $filename = preg_replace('/[\r\n\t -]+/', '_', $filename);
    // convert some special letters
    $convert = [
        'Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss',
        'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u',
    ];
    $filename = strtr($filename, $convert);
    // remove foreign accents by converting to HTML entities, and then remove the code
    $filename = html_entity_decode($filename, ENT_QUOTES, 'utf-8');
    $filename = htmlentities($filename, ENT_QUOTES, 'utf-8');
    $filename = preg_replace('/(&)([a-z])([a-z]+;)/i', '$2', $filename);
    // clean up, and remove repetitions
    $filename = preg_replace('/_+/', '_', $filename);
    $filename = preg_replace(['/ +/', '/-+/'], '_', $filename);
    $filename = preg_replace(['/-*\.-*/', '/\.{2,}/'], '.', $filename);
    // cut to 255 characters
    // $filename = substr($data, 0, 255);
    // remove bad characters at start and end
    $filename = trim($filename, '.-_');

    return $filename;
}

function my_mb_ucfirst($str)
{
    $fc = mb_strtoupper(mb_substr($str, 0, 1));

    return $fc.mb_substr($str, 1);
}

function mb_ucfirst($string, $encoding)
{
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, null, $encoding);

    return mb_strtoupper($firstChar, $encoding).$then;
}

function test_input($data)
{
    // obrezka do 300 znakov na vsak slu4aj
    $data = mb_substr($data, 0, 300);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function phone_number_to_db($sPhone)
{
    $sPhone = preg_replace('![^0-9]+!', '', $sPhone);

    return $sPhone;
}

function phone_number_view($sPhone)
{
    // if(strlen($sPhone) != 11) return(False);
    if (strlen($sPhone) > 10 && strlen($sPhone) < 12) {
        $sPhone = preg_replace('![^0-9]+!', '', $sPhone);
        $sArea = mb_substr($sPhone, 0, 1);
        $sPrefix = mb_substr($sPhone, 1, 3);
        $sNumber1 = mb_substr($sPhone, 4, 3);
        $sNumber2 = mb_substr($sPhone, 7, 2);
        $sNumber3 = mb_substr($sPhone, 9, 2);
        $sPhone = '+'.$sArea.' ('.$sPrefix.') '.$sNumber1.' '.$sNumber2.' '.$sNumber3;

        return $sPhone;
    } else {
        return $sPhone;
    }
}

/**
 * replaces all Cyrillic letters with Latin.
 *
 * @return string
 */
function translit_ostslav_to_lat($textcyr)
{
    $cyr = [
        'Ц', 'ц', 'а', 'б', 'в', 'ў', 'г', 'ґ', 'д', 'е', 'є', 'ё', 'ж', 'з', 'и', 'ï', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Ў', 'Г', 'Ґ', 'Д', 'Е', 'Є', 'Ё', 'Ж', 'З', 'И', 'Ї', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
    ];
    $lat = [
        'C', 'c', 'a', 'b', 'v', 'w', 'g', 'g', 'd', 'e', 'ye', 'io', 'zh', 'z', 'i', 'yi', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya', 'A', 'B', 'V', 'W', 'G', 'G', 'D', 'E', 'Ye', 'Io', 'Zh', 'Z', 'I', 'Yi', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya',
    ];
    $textlat = str_replace($cyr, $lat, $textcyr);

    return $textlat;
}
/**
 * replaces all letters with Latin ASCII.
 *
 * @return string
 */
function translit_to_lat($text)
{
    $res = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', transliterator_transliterate('Any-Latin; Latin-ASCII', $text));

    return $res;
}

function find_by_filename($path, $filename)
{
    if (is_readable($path)) {
        $files = scandir($path);
        if (!empty($files)) {
            foreach ($files as $k => $v) {
                $fname = pathinfo($v, PATHINFO_FILENAME);
                $only_name[$k] = $fname;
            }
            $name_key_name = array_search($filename, $only_name);
            if (!empty($name_key_name)) {
                // return $path.DS.$files[$name_key_name];
                return $files[$name_key_name];
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_page_image($page_alias)
{
    $path = IMGDIR.DS.'pages'.DS;
    if (find_by_filename($path, $page_alias) === false) {
        $img = URLROOT.DS.'public'.DS.'imgs'.DS.'ddd.jpg';
    } else {
        $img = URLROOT.DS.'public'.DS.'imgs'.DS.'pages'.DS.find_by_filename($path, $page_alias);
    }

    return $img;
}

/**
 * @param string $file       - - path to txt file
 * @param string $new_string
 * @param int    $num_string - number of string for replace
 */
function replace_string($file, $new_string, int $num_string = 0)
{
    $array = file($file);
    if ($array) {
        $array[$num_string] = $new_string."\n";
    }
    if (!is_writable($file)) {
        return false;
    }
    if (file_put_contents($file, $array, LOCK_EX) === false) {
        return false;
    } else {
        return true;
    }
}
/**
 * function for url validation.
 *
 * @param string $url
 *
 * @return bool
 */
function getResponseCode($url)
{
    $header = '';
    $options = [
        CURLOPT_URL => trim($url),
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    if (!curl_errno($ch)) {
        $header = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    curl_close($ch);

    if ($header > 0 && $header < 400) {
        return true;
    } else {
        return false;
    }
}

function dir_is_empty($dir)
{
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
        if ($entry != '.' && $entry != '..') {
            closedir($handle);

            return false;
        }
    }
    closedir($handle);

    return true;
}

function del_empty_dir($dir)
{
    if (file_exists($dir) && is_dir($dir) && [] === array_diff(scandir($dir), ['.', '..'])) {
        if (dir_is_empty($dir)) {
            if (rmdir($dir)) {
                return true;
            } else {
                return false;
            }
        }
    }
}

function human_filesize($bytes, $decimals = 2)
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).@$sz[$factor];
}

function in_array_rec($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_rec($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}
