<?php

abstract class Loc {
    /**
     * Default language
     */
    private static $language = null;
    private static $translations = array();

    abstract protected function get_default_language();

    protected function get_translations() {
        return array(
            "all" => array(
                'header' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>
			'.$GLOBALS['brand'].'
		</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
	</head>
	<body>
	<div style="font-family:Arial;font-size:18px;text-align:center;margin:100px auto;border:1px solid black;padding:20px;background-color:#eee;width:700px">',
                'footer' => '</div>
	</body>
	</html>',
            )
        );
    }

    public function get_language_options() {
        return "";
    }

    private static function _get_translations() {
        if (!self::$translations)
            self::$translations = (new Loc())->get_translations();
        return self::$translations;
    }
    
    public static function languages() {
        return array_keys(self::_get_translations());
    }

    /**
     * Gets the language
     */
    public static function get_language() {
        if (!self::$language)
            return (new Loc())->get_default_language();
        return self::$language;
    }

    /**
     * Sets the language
     * @param string $language
     */
    public static function set_language($language) {
        DB::query("UPDATE uvr2web_config SET config_value='" . DB::escape($language) . "' WHERE config_key='language'");
        self::$language = $language;
    }

    /**
     * Reads the current language
     */
    public static function init() {
        $result = DB::query("SELECT * FROM uvr2web_config WHERE config_key='language'");
        if ($result) {
            self::$language = $result[0]['config_value'];
            try {
                Loc::t('sensor');
            } catch (Exception $e) {
                self::$language = (new Loc())->get_default_language();
            }
        } else {
            self::$language = (new Loc())->get_default_language();
            DB::query("INSERT INTO uvr2web_config (config_key, config_value) VALUES('language', '$language')");
        }
    }

    /**
     * Translates a string
     * @param string $key
     */
    public static function t($key) {
        $translations = self::_get_translations();
        $language = self::get_language();
        if (!array_key_exists($language, $translations))
            throw new Exception("language \"$language\" not found");
        if (array_key_exists($key, $translations[$language]))
            return self::_get_translations()[$language][$key];
        else if (array_key_exists($key, $translations["all"]))
            return self::_get_translations()["all"][$key];
        else
            throw new Exception("translation for \"$key\" not found");
    }

    /**
     * Creates an array from a MySQL timestamp
     */
    public static function mysql_timestamp($timestamp) {
        $parts = explode(' ', $timestamp);
        $timestamp1 = explode('-', $parts[0]);
        $timestamp2 = explode(':', $parts[1]);
        $timestamp = array_merge($timestamp1, $timestamp2);
        return $timestamp;
    }

    /**
     * Localizes a value
     * @param mixed $value
     */
    public static function l($value) {
        if (is_array($value)) {
            if (isset($value['l'])) {
                if ($value['l'] == 'month') {
                    $months = Loc::t('months');
                    $month = $months[(int) $value[1] - 1];
                    switch (self::get_language()) {
                    case 'en':
                    case 'fr':
                    case 'de':
                        return "$month $value[0]";
                        break;
                    }
                } else if ($value['l'] == 'date') {
                    $months = Loc::t('months');
                    $month = $months[(int) $value[1] - 1];
                    switch (self::get_language()) {
                    case 'en':
                    case 'fr':
                        return "$value[2] $month $value[0]";
                        break;
                    case 'de':
                        return "$value[2]. $month $value[0]";
                        break;
                    }
                } else if ($value['l'] == 'time') {
                    switch (self::get_language()) {
                    case 'en':
                    case 'de':
                    case 'fr':
                        return "$value[3]:$value[4]";
                        break;
                    }
                }
            } else {
                throw new Exception('Please specify l=>date or l=>time');
            }
        } else {
            switch (self::get_language()) {
            case 'en':
                return (string) $value;
                break;
            case 'de':
            case 'fr':
                return str_replace('.', ',', (string) $value);
                break;
            }
        }
    }
}

?>