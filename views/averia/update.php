<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Averia */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Averia',
]) . ' ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Averias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->codigo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="averia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
