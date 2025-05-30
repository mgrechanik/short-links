<?php
/**
 * This file is part of the mgrechanik/short-links project
 *
 * @copyright Copyright (c) Mikhail Grechanik <mike.grechanik@gmail.com>
 * @license https://github.com/mgrechanik/short-links/blob/main/LICENSE.md
 * @link https://github.com/mgrechanik/short-links
 */
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\assets\MainPageAsset;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\ShortLink $model */
/** @var yii\bootstrap5\ActiveForm $form */

MainPageAsset::register($this);
?>

<div class="short-link-form">

    <?php $form = ActiveForm::begin([
        'id' => 'short-link-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['site/ajax-validation']),
    ]); ?>

    <?= $form->field($model, 'long_url', ['enableAjaxValidation' => true])->textInput() ?>

    <div><div id="res-url"></div><div id="res-qr"></div></div>

    <div class="form-group">
        <?= Html::submitButton('OK', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
