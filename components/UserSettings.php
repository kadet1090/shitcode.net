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

use nezhelskoy\highlight\HighlightAsset;
use trntv\aceeditor\AceEditorAsset;
use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\web\Cookie;
use yii\web\CookieCollection;

/**
 * @property mixed highlightStyle
 */
class UserSettings extends Component
{
    public $defaultHighlightStyle;
    public $defaultAceStyle;

    /**
     * @var CookieCollection
     */
    private $_cookies;

    private $_hjs;
    private $_ace;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        $this->_hjs = Yii::$app->assetManager->getBundle(HighlightAsset::className());
        $this->_ace = Yii::$app->assetManager->getBundle(AceEditorAsset::className());

        $this->_hjs->css = [
            'dist/styles/'.$this->highlightStyle.'.css'
        ];



        parent::init();
    }

    public function getHighlightStyle() {
        return Yii::$app->request->cookies->getValue('highlight-style', $this->defaultHighlightStyle);
    }

    public function getAceStyle() {
        return Yii::$app->request->cookies->getValue('ace-style', $this->defaultAceStyle);
    }

    public function setHighlightStyle($style) {
        if(!Yii::$app->assetManager->getAssetPath($this->_hjs, 'dist/styles/'.$style.'.css'))
            throw new InvalidParamException();

        $cookie = new Cookie(['name' => 'highlight-style', 'value' => $style]);
        Yii::$app->response->cookies->add($cookie);
    }

    public function setAceStyle($style) {
        if(!Yii::$app->assetManager->getAssetPath($this->_ace, 'theme-'.$style.'.js'))
            throw new InvalidParamException();

        $cookie = new Cookie(['name' => 'ace-style', 'value' => $style]);
        Yii::$app->response->cookies->add($cookie);
    }
}