<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PersonaB */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persona-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'apellido') ?>

    <?= //$form->field($model, 'dui') ?>

    <?= //$form->field($model, 'nit') ?>

    <?php echo $form->field($model, 'fecha_nacimiento') ?>

    <?php echo $form->field($model, 'genero') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'profesion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'cod_municipio') ?>

    <?php // echo $form->field($model, 'cod_nacionalidad') ?>

    <?php // echo $form->field($model, 'cod_estado_civil') ?>

    <?php // echo $form->field($model, 'nombre_usuario') ?>

    <?php // echo $form->field($model, 'carnet_minoridad') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
