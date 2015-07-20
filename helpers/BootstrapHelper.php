<?php
namespace app\helpers;

use Yii;
use yii\helpers\Html;


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
class BootstrapHelper
{
    public static function glyphicon($icon)
    {
        return Html::tag('span', null, [
            'class' => "glyphicon glyphicon-$icon",
            'aria-hidden' => true
        ]);
    }
}