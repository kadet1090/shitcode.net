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

namespace app\widgets;


use yii\base\Widget;

class Paste extends Widget
{
    public $model = null;
    public $actions = [];

    public function run()
    {
        return $this->render('paste', [
            'model' => $this->model,
            'actions' => $this->actions
        ]);
    }
}