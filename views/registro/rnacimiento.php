<?php

use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\mant\Persona;
use app\models\mant\Informante;
use app\models\mant\Departamento;
use app\models\mant\Municipio;
use app\models\mant\Hospital;

/* @var $this yii\web\View */
/* @var $model app\models\mant\Nacimiento */
/* @var $form ActiveForm */
$this->title = 'Inscripción de Nacimiento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rmatrimonio">
    <?php $form = ActiveForm::begin(); ?>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_libro')->textInput(array('readOnly'=>true,'value'=>3)) ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'folio')->textInput(array('readOnly'=>true,'value'=>21)) ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'numero')->textInput(array('readOnly'=>true,'value'=>22)) ?>
      </span>
    </div>
    <div class="cflex">
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
    <div class="cflex">
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
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_municipio')->dropDownList(ArrayHelper::map(Departamento::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique el departamento'])->label('Departamento') ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'cod_municipio')->dropDownList(ArrayHelper::map(Municipio::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique el municipio']) ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'lugar_suceso')->textInput(array('placeholder'=>'Especifique el lugar'))->label('Lugar de Nacimiento') ?>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'fecha_emision')->textInput(array('readOnly'=>true,'value'=>date('d/m/Y'))) ?>
      </span>
      <span style="order: 2; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida,'fecha_suceso')->widget(DatePicker::className(),[
                    'language'=>'es',
                    'readonly'=>true,
                    'options'=>['placeholder'=>'Especifique la fecha'],
                    'pluginOptions'=>['format'=>'dd/mm/yyyy','autoclose'=>true],
                    ])->label('Fecha de Nacimiento');
                ?>
      </span>
      <span style="order: 3; flex-grow: 1; margin-right:10px;">
        <?= $form->field($partida, 'hora_suceso')->widget(TimePicker::className(), ['language'=>'es', 'pluginOptions'=>[
            'showMeridian'=>true, 'autoclose'=>true], 'options'=>['readonly'=>true]
            ])->label('Hora de Nacimiento');
        ?>
      </span>
    </div>
    <div class="cflex">
      <span style="order: 1; flex-grow: 1; margin-right:10px;">
        <?= $form->field($model, 'cod_hospital')->dropDownList(ArrayHelper::map(Hospital::find()->all(), 'codigo', 'nombre'), ['prompt'=>'Especifique el hospital']) ?>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-edit"></i>
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="glyphicon glyphicon-search"></i>
        </button>
      </span>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Vista Previa', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- rnacimiento -->
