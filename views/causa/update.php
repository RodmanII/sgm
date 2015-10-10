<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\mant\CausaDefuncion */

$this->title = 'Update Causa Defuncion: ' . ' ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Causa Defuncions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->codigo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="causa-defuncion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
