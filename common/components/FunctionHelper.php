<?php

namespace common\components;

class FunctionHelper
{
    public static function arrayToCsv($dataArray, $delimiter = ';', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'r+');
        foreach ($dataArray as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    /**
     * Get ModelName from app\models\ModelName
     * @param string $name
     * @return false|mixed|string
     */
    public static function getShortClassName(string $name)
    {
        $array = explode('\\', $name);
        return end($array);
    }

    /**
     *
     * @param $number
     * @return string
     */
    public static function phoneNumberSanitize($number)
    {
        // Allow only Digits, remove all other characters.
        $number = preg_replace('/[^\d]/', '', $number);

        // get number length.
        $length = strlen($number);

        // if number = 935465615
        if ($length === 9) {
            $number = '380' . $number;
        }

        // if number = 0935465615
        if ($length === 10) {
            $number = '38' . $number;
        }

        return $number;
    }

    public static function phoneNumberFormat($number)
    {
        // Allow only Digits, remove all other characters.
        $number = preg_replace('/[^\d]/', '', $number);

        // get number length.
        $length = strlen($number);

        // if number = 0935465615
        if ($length === 10) {
            $number = preg_replace('/^1?(\d{3})(\d{3})(\d{2})(\d{2})$/', '($1) $2-$3-$4', $number);
        }

        // if number = 380978325505
        if ($length === 12) {
            //$number = preg_replace('/^1?(\d{2})(\d{3})(\d{3})(\d{2})(\d{2})$/', '+$1($2) $3-$4-$5', $number);
            $number = preg_replace('/^1?(\d{2})(\d{3})(\d{3})(\d{2})(\d{2})$/', '($2) $3-$4-$5', $number);
        }

        return $number;
    }

    /**
     * Prepare string for use in filename
     * @param $string
     * @return string
     */
    public static function slugifyFileName($string): string
    {

        $string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string);

        $string = preg_replace('/[-\s]+/', '-', $string);

        return trim($string, '-');
    }

    /**
     * Get Dsn Attribute from connection string, example: dbname
     * @param $name
     * @param $dsn
     * @return mixed|null
     */
    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }

    }
}
