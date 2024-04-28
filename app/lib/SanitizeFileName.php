<?php

namespace App\Lib;

class SanitizeFileName
{
    public static function run($filename, $beautify = true)
    {
        // sanitize filename
        $filename = preg_replace(
            '~
            [<>:"/\\\|?*]|           # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
            [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
            [\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
            [#\[\]@!$&\'()+,;=]|     # URI reserved https://www.rfc-editor.org/rfc/rfc3986#section-2.2
            [{}^\~`]|—|-             # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt and - and —
            ~x',
            '_',
            $filename
        );
        // avoids ".", ".." or ".hiddenFiles"
        $filename = ltrim($filename, '._');
        // optional beautification
        if ($beautify) {
            $filename = self::beautify_filename($filename);
        }
        // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = mb_strcut(pathinfo($filename, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($filename)).($ext ? '.'.$ext : '');

        return $filename;
    }

    public static function beautify_filename($filename)
    {
        // reduce consecutive characters
        $filename = preg_replace([
            // "file   name.zip" becomes "file-name.zip"
            '/ +/',
            // "file___name.zip" becomes "file-name.zip"
            '/_+/',
            // "file---name.zip" becomes "file-name.zip"
            '/_+/',
        ], '_', $filename);
        $filename = preg_replace([
            // "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // "file__.__._.__name.zip" becomes "file.name.zip"
            '/_*\._*/',
            // "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/',
        ], '.', $filename);
        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file_name"
        $filename = trim($filename, '._');

        return $filename;
    }
}
