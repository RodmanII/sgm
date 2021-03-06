<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\InformanteB */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informante-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'tipo_documento') ?>

    <?= $form->field($model, 'numero_documento') ?>

    <?= $form->field($model, 'genero') ?>

    <?php // echo $form->field($model, 'cod_persona') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
