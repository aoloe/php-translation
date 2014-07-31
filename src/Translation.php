<?php
/**
 * provide the tr() (or Translation::tr()) function for translating text in the output.
 * the library is optimized for sites with only few translated strings
 */

if (!function_exists('tr')) {
    function tr($text) {return Translation::tr($text);}
}

namespace Aoloe;

class Translation {
    static private $translation = array();
    static public function clear() {self::$translation = array();}
    static public function read($filename, $language) {
        if (file_exists($filename)) {
            foreach (Spyc::YAMLLoadString(file_get_contents($filename)) as $key => $value) {
                self::$translation[$key] = $value[$language];
            }
        }
    }
    static private $untranslated = array();
    static function tr($text) {
        $text = strtr($text, ' ', '_');
        if (array_key_exists($text, self::$translation)) {
            return self::$translation[$text];
        } else {
            self::$untranslated[$text] = "caller file and line";
            return '«'.$text.'»';
        }
    }
}