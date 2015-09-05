<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Lugar */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Lugar',
]) . ' ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lugars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->codigo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="lugar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
