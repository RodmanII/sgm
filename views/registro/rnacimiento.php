<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\mant\Persona;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Nacimiento */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Nacimiento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rnacimiento">

    <?php $form = ActiveForm::begin(); ?>
    <div style="display:flex; flex-wrap: wrap;">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_libro')->textInput(array('readOnly'=>true,'value'=>2)) ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'folio')->textInput(array('readOnly'=>true,'value'=>3)) ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'numero')->textInput(array('readOnly'=>true,'value'=>1)) ?>
      </span>
    </div>
    <div style="display:flex; flex-wrap: wrap;">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_asentado')->dropDownList(ArrayHelper::map(Persona::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique al inscrito']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_madre')->dropDownList(ArrayHelper::map(Persona::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique a la madre']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_padre')->dropDownList(ArrayHelper::map(Persona::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique al padre']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
    </div>
    <div style="display:flex; flex-wrap: wrap;">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_informante')->dropDownList(ArrayHelper::map(Informante::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique al informante']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
    </div>
        <?= $form->field($model, 'cod_hospital') ?>
        <?= $form->field($model, 'num_partida') ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Vista Previa', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- rnacimiento -->
