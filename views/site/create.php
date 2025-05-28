<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ShortLink $model */

$this->title = 'Создание короткой ссылки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'model' => $model,
    ]) ?>

</div>
