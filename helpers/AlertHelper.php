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
class AlertHelper
{
    public static function appendAlert($type, $message, $options = [])
    {
        array_push($_SESSION['alerts'], [
            'type' => $type,
            'message' => $message,
            'options' => $options
        ]);
    }

    public static function prependAlert($type, $message, $options = [])
    {
        array_unshift($_SESSION['alerts'], [
            'type' => $type,
            'message' => $message,
            'options' => $options
        ]);
    }

    public static function render() {
        if(empty($_SESSION['alerts'])) return '';

        $alerts = $_SESSION['alerts'];
        unset($_SESSION['alerts']);

        $result = '';
        foreach($alerts as $alert)
            $result .= self::alert($alert['type'], $alert['message'], $alert['options']).PHP_EOL;

        return $result;
    }

    public static function alert($type, $message, $options = []) {
        $dismissible = true;
        if(isset($options['dismissible'])) {
            $dismissible = (bool)$options['dismissible'];
            unset($options['dismissible']);
        }

        $dismiss = $dismissible ?
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.PHP_EOL :
            '';

        $options['class'] = (isset($options['class']) ? $options['class'].' ' : '')."alert alert-{$type}";

        return Html::tag('div', $dismiss.$message, $options);
    }
}

// So, php cannot into static constructors.

if (!Yii::$app->session->isActive)
    Yii::$app->session->open();

if(!isset($_SESSION['alerts'])) $_SESSION['alerts'] = [];