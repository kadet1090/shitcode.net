<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="banner">
    <div class="navbar navbar-default" id="nav-affix">
        <div class="container-fluid">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="/"><?= Yii::$app->name ?></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/latest'): ?>class="active"<?php endif;?>>
                            <?= Html::a(Yii::t('happycode', 'Latest'), ['site/latest']) ?>
                        </li>
                        <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/index'): ?>class="active"<?php endif;?>>
                            <?= Html::a(Yii::t('happycode', 'Browse'), ['site/index']) ?>
                        </li>
                        <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/best'): ?>class="active"<?php endif;?>>
                            <?= Html::a(Yii::t('happycode', 'Top'), ['site/best']) ?>
                        </li>
                        <li <?php if(Yii::$app->requestedAction->uniqueId == 'site/worst'): ?>class="active"<?php endif;?>>
                            <?= Html::a(Yii::t('happycode', 'Worst'), ['site/worst']) ?>
                        </li>
                        <li class="add <?php if(Yii::$app->requestedAction->uniqueId == 'site/add'): ?>active<?php endif;?>">
                            <?= Html::a(
                                Yii::t('happycode', 'Add').' '.\app\helpers\BootstrapHelper::glyphicon('plus'),
                                ['site/add']
                            ) ?>
                        </li>
                        <li class="settings dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin"><?= \app\helpers\BootstrapHelper::glyphicon('cog') ?></a>
                            <div class="dropdown-menu dropdown-menu-right" style="padding:15px; width: 350px;">
                                <?= Html::beginForm(['site/save-settings'], 'post', ['id' => 'settings-form']) ?>
                                <div class="form-group">
                                    <label for="theme-settings"><?= Yii::t('happycode', 'Highlight theme:'); ?></label>
                                    <select name="highlight-style" id="theme-settings" class="form-control">
                                        <?php foreach(Yii::$app->params['highlight-styles'] as $style => $name):?>
                                            <option value="<?=$style?>"
                                                    <?php if($style == Yii::$app->userSettings->highlightStyle): ?>selected="selected"<?php endif; ?>>
                                                <?= $name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ace-settings"><?= Yii::t('happycode', 'Editor theme:'); ?></label>
                                    <select name="ace-style" id="ace-settings" class="form-control">
                                        <?php foreach(Yii::$app->params['ace-styles'] as $style => $name):?>
                                            <option value="<?=$style?>"
                                                    <?php if($style == Yii::$app->userSettings->aceStyle): ?>selected="selected"<?php endif; ?>>
                                                <?= $name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button class="btn btn-block btn-primary">Save</button>
                                <?= Html::endForm(); ?>
                            </div>
                        </li>
                        <?php if(!Yii::$app->user->isGuest): ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                    Admin
                                    <?php if (\app\models\Code::countPending() > 0): ?>
                                        <span class="badge"><?= \app\models\Code::countPending() ?></span>
                                    <?php endif;?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="<?= Url::to(['admin/pending']) ?>"><?= Yii::t('happycode', 'Pending'); ?> <span class="badge"><?= \app\models\Code::countPending() ?></span></a></li>
                                    <li><a href="<?= Url::to(['admin/add-admin']) ?>"><?= Yii::t('happycode', 'Add admin'); ?></a></li>
                                    <li><a href="<?= Url::to(['admin/change-password']) ?>"><?= Yii::t('happycode', 'Change password'); ?></a></li>
                                    <li><a href="<?= Url::to(['admin/logout']) ?>"><?= Yii::t('happycode', 'Logout'); ?></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>