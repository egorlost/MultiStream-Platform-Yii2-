<?php

namespace app\extensions;

/**
 * Created by PhpStorm.
 * User: egor
 * Date: 01.12.2016
 * Time: 12:37
 */
class Helper
{
    public static function seoTranslit($string, $count_chars = 150)
    {
        $string = trim(html_entity_decode($string));
        $string = preg_replace("/\s{2,}/", " ", $string);
        $alphavit = array("а" => "a", "б" => "b", "в" => "v", "г" => "g", "ґ" => "g", "д" => "d", "е" => "e", "є" => "ye",
            "ё" => "e", "ж" => "zh", "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l", "м" => "m",
            "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t",
            "у" => "u", "ф" => "f", "х" => "kh", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "shch",
            "ы" => "y", "э" => "e", "ю" => "yu", "я" => "ya", "ь" => "", "ъ" => "", "і" => "i", "ї" => "yi",
            "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Ґ" => "g", "Д" => "d", "Е" => "e", "Є" => "ye",
            "Ё" => "e", "Ж" => "zh", "З" => "z", "И" => "i", "Й" => "y", "К" => "k", "Л" => "l", "М" => "m",
            "Н" => "n", "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t",
            "У" => "u", "Ф" => "f", "Х" => "kh", "Ц" => "ts", "Ч" => "ch", "Ш" => "sh", "Щ" => "shch",
            "Ы" => "y", "Э" => "e", "Ю" => "yu", "Я" => "ya", "Ь" => "", "Ъ" => "", "І" => "i", "Ї" => "yi", "&" => "_and_", "-" => "_", "|" => "_", ":" => "_",
            " " => "_",);
        $string = strtr($string, $alphavit);
        $string = strtolower($string);
        $string = preg_replace("/\_{2,}/", "_", $string);
        $string = preg_replace(array("/^\_*/", "/\W/", "/\_*$/"), "", $string);
        $string = preg_replace(array("/\_/"), "-", $string);
        $string = mb_substr($string, 0, $count_chars);
        return $string;
    }
}