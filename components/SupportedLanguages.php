<?php
/**
 * Copyright (C) 2015, Some right reserved.
 *
 * @author  Kacper "Kadet" Donat <kadet1090@gmail.com>
 * @license http://creativecommons.org/licenses/by-sa/4.0/legalcode CC BY-SA
 *
 * Contact with author:
 * Xmpp: kadet@jid.pl
 * E-mail: kadet1090@gmail.com
 *
 * From Kadet with love.
 */

namespace app\components;

use Yii;
use yii\base\Component;

if (!function_exists('array_column')) {
    function array_column(array $array, $column_key, $index_key = null)
    {
        $result = [];
        foreach ($array as $arr) {
            if (!is_array($arr)) continue;

            if (is_null($column_key)) {
                $value = $arr;
            } else {
                $value = $arr[$column_key];
            }

            if (!is_null($index_key)) {
                $key          = $arr[$index_key];
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }

        }

        return $result;
    }
}

/**
 * @property string[] ace
 * @property string[] hljs
 */
class SupportedLanguages extends Component
{
    public $languages;


    public function getHljs()
    {
        return array_column($this->languages, 'label', 'hljs');
    }

    public function getAce()
    {
        return array_column($this->languages, 'label', 'ace');
    }
}